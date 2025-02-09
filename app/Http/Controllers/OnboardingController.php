<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;
use App\Models\Profile;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Log;

class OnboardingController extends Controller
{
    public function index()
    {
        return inertia('Onboarding');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // 🔹 Crear la empresa y base de datos
        $empresaNombre = strtolower($request->empresa_nombre);
        $dbName = $empresaNombre;

        DB::statement("CREATE DATABASE IF NOT EXISTS {$dbName}");

        $empresa = Empresa::create([
            'nombre' => $empresaNombre,
            'db_name' => $dbName,
        ]);

        // 🔹 Actualizar usuario en la base de datos principal
        $user->update([
            'onboarding_completo' => true,
            'empresa_id' => $empresa->id,
        ]);

        // 🔄 Recargar el usuario actualizado
        Auth::setUser($user);

        // 🔄 Configurar conexión a la base de datos tenant
        config(['database.connections.tenant.database' => $dbName]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        // 🔹 Ejecutar migraciones en la base de datos tenant
        Artisan::call('migrate', ['--database' => 'tenant', '--force' => true]);

        // 🔹 Crear empresa en tenant
        $tenantEmpresa = Empresa::on('tenant')->create([
            'id' => $empresa->id,
            'nombre' => $empresaNombre,
            'db_name' => $dbName,
        ]);

        // 🔹 Crear roles en tenant
        $roles = ['admin', 'empleado', 'gerente'];
        foreach ($roles as $role) {
            Role::on('tenant')->firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        // 🔹 Crear usuario en tenant
        $tenantUser = User::on('tenant')->firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'password' => bcrypt(uniqid()),
                'empresa_id' => $tenantEmpresa->id,
                'onboarding_completo' => true,
            ]
        );

        // 🔹 Asignar el rol de admin
        $adminRole = Role::on('tenant')->where('name', 'admin')->first();
        if ($adminRole) {
            $tenantUser->assignRole($adminRole);
        } else {
            Log::error("⚠️ El rol 'admin' no se creó correctamente en la base de datos tenant.");
        }

        // 🔹 **Crear perfil en la base de datos tenant**
        $profile = Profile::on('tenant')->updateOrCreate(
            ['user_id' => $tenantUser->id],
            [
                'dashboard_name' => $request->dashboard_name,
                'empresa_nombre' => $empresaNombre,
                'empresa_tipo' => $request->empresa_tipo,
                'modulos' => $request->modulos,
                'onboarding_completo' => true,
            ]
        );

        // 🔹 **Registrar logs para verificar si el perfil se creó**
        Log::info('Perfil creado en tenant:', [
            'database' => DB::connection('tenant')->getDatabaseName(),
            'user_id' => $tenantUser->id,
            'profile' => $profile,
        ]);

        // 🔄 Cerrar sesión y volver a iniciar sesión
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // 🔄 Iniciar sesión con el usuario correcto
        Auth::login($user);

        // 🔄 Actualizar sesión con la empresa correcta
        session()->put('empresa_id', $empresa->id);
        session()->save();

        // 🔄 Forzar el cambio de base de datos en la siguiente petición
        DB::purge('tenant');
        DB::reconnect('tenant');

        return redirect()->route('dashboard')->with('success', 'Onboarding completado correctamente');
    }
}
