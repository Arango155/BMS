<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller {
    public function index() {
        $user = auth()->user();
        $profile = $user->profile; // Asegúrate de que el perfil está siendo cargado correctamente

        return Inertia::render('Dashboard', [
            'profile' => $profile,  // Asegúrate de que se pasa el perfil correctamente
        ]);
    }

}
