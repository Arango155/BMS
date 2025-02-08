<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');

        // 🔹 Obtener el rol del usuario desde la base de datos tenant
        $tenantUser = \App\Models\User::on('tenant')->find($user->id);
        $role = $tenantUser ? $tenantUser->getRoleNames()->first() : 'sin rol';

        return Inertia::render('Dashboard', [
            'profile' => $user->profile ?? null,
            'auth' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role, // 🔥 Ahora sí se envía el rol correcto
                ],
            ],
        ]);
    }
}
