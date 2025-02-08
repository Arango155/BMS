<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvitationController;

// 🏠 Página de bienvenida
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// 🔐 Grupo de rutas protegidas por autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {

    // 🚀 Onboarding (para usuarios que no han completado su perfil)
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    // 🔹 Rutas protegidas con `onboarding.complete` (solo para usuarios que ya completaron onboarding)
    Route::middleware(['onboarding.complete'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('users.index'); // ✅ Nueva ruta agregada
        Route::post('/invite', [InvitationController::class, 'invite'])->name('invite.send');

    });

    // 👤 Gestión de perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔐 Autenticación con redes sociales
Route::prefix('auth')->group(function () {
    Route::get('{provider}', function ($provider) {
        return Socialite::driver($provider)->redirect();
    });

    Route::get('{provider}/callback', function ($provider) {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName(),
                'password' => bcrypt(uniqid()), // 🔐 Contraseña aleatoria segura
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    });
});

//Rutas para aceptar invitaciones

Route::get('/accept-invitation/{token}', [InvitationController::class, 'accept'])->name('invite.accept');
Route::post('/register-invited', [InvitationController::class, 'registerInvitedUser'])->name('invite.register');

// 🔄 Rutas de autenticación proporcionadas por Laravel Breeze/Fortify
require __DIR__.'/auth.php';
