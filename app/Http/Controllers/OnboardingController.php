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

class OnboardingController extends Controller
{
    public function index()
    {
        return inertia('Onboarding');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // 🔹 **Crear la empresa y base de datos**
        $empresaNombre = strtolower($request->empresa_nombre);
        $dbName = $empresaNombre;

        DB::statement("CREATE DATABASE IF NOT EXISTS {$dbName}");

        $empresa = Empresa::create([
            'nombre' => $empresaNombre,
            'db_name' => $dbName,
        ]);

        // 🔹 **Actualizar el usuario en la base de datos principal**
        User::where('id', $user->id)->update([
            'onboarding_completo' => true,
            'empresa_id' => $empresa->id,
        ]);

        // 🔹 **Recargar el usuario para asegurarnos de que Laravel usa los datos actualizados**
        $user = User::find($user->id);
        Auth::setUser($user);

        // 🔹 **Configurar la conexión a la base de datos tenant**
        config(['database.connections.tenant.database' => $dbName]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        // 🔹 **Ejecutar migraciones en la base de datos tenant**
        Artisan::call('migrate', ['--database' => 'tenant', '--force' => true]);

        // 🔹 **Registrar la empresa en la base de datos tenant**
        $tenantEmpresa = Empresa::on('tenant')->create([
            'id' => $empresa->id,
            'nombre' => $empresaNombre,
            'db_name' => $dbName,
        ]);

        // 🔹 **Crear roles por defecto en el tenant**
        $roles = ['admin', 'empleado', 'gerente'];
        foreach ($roles as $role) {
            Role::on('tenant')->firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        // 🔹 **Crear usuario en tenant**
        $tenantUser = User::on('tenant')->firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'password' => bcrypt(uniqid()),
                'empresa_id' => $tenantEmpresa->id,
                'onboarding_completo' => true,
            ]
        );

        // 🔹 **Asignar el rol de admin al usuario creador**
        $adminRole = Role::on('tenant')->where('name', 'admin')->first();
        if ($adminRole) {
            $tenantUser->assignRole($adminRole);
        } else {
            \Log::error("⚠️ El rol 'admin' no se creó correctamente en la base de datos tenant.");
        }

        // 🔹 **Crear perfil en la base de datos tenant**
        Profile::on('tenant')->updateOrCreate(
            ['user_id' => $tenantUser->id],
            [
                'dashboard_name' => $request->dashboard_name,
                'empresa_nombre' => $empresaNombre,
                'empresa_tipo' => $request->empresa_tipo,
                'modulos' => $request->modulos,
                'onboarding_completo' => true,
            ]
        );

        // 🔹 **Recargar y autenticar correctamente al usuario en la base de datos principal**
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $user = User::where('email', $tenantUser->email)->first();
        if ($user) {
            Auth::login($user);
            session()->put('empresa_id', $empresa->id);
            session()->save();
        } else {
            \Log::error("❌ No se pudo encontrar el usuario en la base de datos principal.");
            return redirect()->route('onboarding')->with('error', 'Hubo un problema con la autenticación.');
        }

        return redirect()->route('dashboard')->with('success', 'Onboarding completado correctamente');
    }
}
