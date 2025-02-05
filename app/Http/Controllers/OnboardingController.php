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

        // Validación de los campos con los nombres correctos
        $request->validate([
            'dashboard_name' => 'required|string|max:255', // Validar nombre del dashboard
            'empresa_nombre' => 'required|string|max:255', // Cambiado de "empresa"
            'empresa_tipo' => 'required|string|max:255',   // Cambiado de "tipo_empresa"
            'modulos' => 'required|string|max:255',         // Validación de modulos
            'onboarding_completo' => 'required|boolean',    // Validación de onboarding
        ]);

        $user = Auth::user();
        Log::info('User before update', ['user' => $user]);

        // Asegurar que el usuario tiene un perfil
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        // Actualizar el perfil con los campos del frontend
        $profile->dashboard_name = $request->dashboard_name;  // Añadir nombre del dashboard
        $profile->empresa_nombre = $request->empresa_nombre;  // Cambiado de "empresa"
        $profile->empresa_tipo = $request->empresa_tipo;      // Cambiado de "tipo_empresa"
        $profile->modulos = $request->modulos;                 // Guardar modulos
        $profile->onboarding_completo = $request->onboarding_completo;  // Guardar onboarding completo
        $profile->save();

        // Actualizar el usuario
        $user->onboarding_completo = true;
        $user->save();

        Log::info('User after update', ['user' => $user]);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Onboarding completado correctamente.');
    }
}
