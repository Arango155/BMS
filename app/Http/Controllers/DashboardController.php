<?php


namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Profile;
use Spatie\Permission\Models\Role;


class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $currentDatabase = DB::connection('tenant')->getDatabaseName();
        $tenantUser = User::on('tenant')->with('profile')->find($user->id);

        $profile = $tenantUser ? $tenantUser->profile : null;
        $roles = $tenantUser ? $tenantUser->getRoleNames() : collect([]);

        \Log::info('Base de datos activa:', [
            'database' => $currentDatabase,
            'user_id' => $user->id,
            'profile' => $profile,
            'roles' => $roles
        ]);

        return Inertia::render('Dashboard', [
            'profile' => $profile,
            'auth' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $roles, // 👈 Ahora los roles están disponibles en el frontend
                ],
            ],
            'currentDatabase' => $currentDatabase,
        ]);
    }
}
