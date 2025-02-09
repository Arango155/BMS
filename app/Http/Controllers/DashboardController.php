<?php


namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Profile;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // No cargamos aún el perfil

        // 🔹 Obtener el nombre de la base de datos actual
        $currentDatabase = DB::connection('tenant')->getDatabaseName();

        // 🔹 Buscar el usuario en la base tenant
        $tenantUser = User::on('tenant')->with('profile')->find($user->id);

        // 🔹 Verificar si tiene un perfil en la base tenant
        $profile = $tenantUser ? $tenantUser->profile : null;

        \Log::info('Base de datos activa:', ['database' => $currentDatabase, 'user_id' => $user->id, 'profile' => $profile]);

        return Inertia::render('Dashboard', [
            'profile' => $profile,
            'auth' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ],
            'currentDatabase' => $currentDatabase, // 🔥 Enviar base de datos al frontend
        ]);
    }
}
