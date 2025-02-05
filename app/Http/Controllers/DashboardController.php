<?php
namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller {
    public function index() {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el perfil del usuario existe
        $profile = $user->profile;

        // Verificar si el perfil está presente, si no, se podría redirigir o mostrar un mensaje
        if (!$profile) {
            // Puedes redirigir o manejar el error de forma más amigable
            return redirect()->route('onboarding'); // O cualquier otra ruta según tu flujo
        }

        // Pasar los datos del perfil a la vista
        return Inertia::render('Dashboard', [
            'profile' => $profile,  // Pasar el perfil para que esté disponible en la vista
        ]);
    }
}
