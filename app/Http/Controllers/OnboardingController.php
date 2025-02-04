<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Profile;

class OnboardingController extends Controller
{
    public function index()
    {
        return inertia('Onboarding');
    }

    public function store(Request $request)
    {
        Log::info('Onboarding request received', $request->all());

        $request->validate([
            'empresa' => 'required|string|max:255',
            'tipo_empresa' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        Log::info('User before update', ['user' => $user]);

        // Asegurar que el usuario tiene un perfil
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        // Actualizar perfil
        $profile->empresa_nombre = $request->empresa;
        $profile->empresa_tipo = $request->tipo_empresa;
        $profile->save();

        // Actualizar el usuario
        $user->onboarding_completo = true;
        $user->save();

        Log::info('User after update', ['user' => $user]);

        return redirect()->route('dashboard')->with('success', 'Onboarding completado correctamente.');
    }
}
