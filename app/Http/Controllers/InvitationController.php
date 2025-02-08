<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Invitation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Inertia\Inertia;

use Illuminate\Support\Facades\Redirect;


class InvitationController extends Controller
{


    public function invite(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:admin,empleado,gerente',
        ]);

        // Obtener usuario y empresa actual
        $user = Auth::user();
        $empresa = DB::connection('tenant')->table('empresas')->where('id', $user->empresa_id)->first();

        if (!$empresa) {
            return Redirect::back()->with('error', 'Empresa no encontrada.');
        }

        // Crear token único para la invitación
        $token = Str::random(32);

        // Insertar invitación en la base de datos tenant
        DB::connection('tenant')->table('invitations')->insert([
            'email' => $request->email,
            'empresa_id' => $empresa->id,
            'role' => $request->role,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return Redirect::back()->with('success', 'Invitación enviada con éxito.');
    }

}
