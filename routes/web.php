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
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\OrdenCompraController;
use App\Http\Controllers\ProveedorController;


Route::get('/test-layout', function () {
    return Inertia::render('AuthLayoutTest');
})->name('test.layout');

Route::get('/api/users', [UserController::class, 'getUsers']);

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
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
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

// Rutas para aceptar invitaciones
Route::get('/accept-invitation/{token}', [InvitationController::class, 'accept'])->name('invite.accept');
Route::post('/register-invited', [InvitationController::class, 'registerInvitedUser'])->name('invite.register');

// 🔄 Rutas de autenticación proporcionadas por Laravel Breeze/Fortify
require __DIR__.'/auth.php';

// 📦 Inventario general
Route::get('/inventario', function () {
    return Inertia::render('Inventario');
})->name('inventario');

// 📌 Submódulos del inventario
Route::get('/inventario/Proveedor', function () {
    return Inertia::render('Inventario/Proveedor');
})->name('inventario.Proveedor');

Route::get('/inventario/Categorias', function () {
    return Inertia::render('Inventario/Categorias');
})->name('inventario.Categorias');

Route::get('/inventario/Usuarios', function () {
    return Inertia::render('Inventario/Usuarios');
})->name('inventario.Usuarios');

Route::get('/inventario/Productos', function () {
    return Inertia::render('Inventario/Productos');
})->name('inventario.Productos');

Route::get('/inventario/Clientes', function () {
    return Inertia::render('Inventario/Clientes');
})->name('inventario.Clientes');

Route::get('/inventario/Ventas', function () {
    return Inertia::render('Inventario/Ventas');
})->name('inventario.Ventas');

Route::get('/inventario/Cotizaciones', function () {
    return Inertia::render('Inventario/Cotizaciones');
})->name('inventario.Cotizaciones');

Route::get('/inventario/Devoluciones', function () {
    return Inertia::render('Inventario/Devoluciones');
})->name('inventario.Devoluciones');

Route::get('/inventario/Compras', function () {
    return Inertia::render('Inventario/Compras');
})->name('inventario.Compras');

// 📌 Rutas para Caja utilizando `CajaController`
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/inventario/caja', [CajaController::class, 'index'])->name('inventario.caja');
    Route::post('/inventario/caja/store', [CajaController::class, 'store'])->name('inventario.caja.store');
    Route::get('/inventario/caja/{id}/edit', [CajaController::class, 'edit'])->name('inventario.caja.edit');
    Route::put('/inventario/caja/{id}/update', [CajaController::class, 'update'])->name('inventario.caja.update');
    Route::delete('/inventario/caja/destroy/{id}', [CajaController::class, 'destroy']);
    Route::get('/inventario/caja/list', [CajaController::class, 'list']);


    Route::get('/inventario/categorias/list', [CategoriaController::class, 'list']);
    Route::post('/inventario/categorias/store', [CategoriaController::class, 'store']);
    Route::put('/inventario/categorias/{id}/update', [CategoriaController::class, 'update']);
    Route::delete('/inventario/categorias/destroy/{id}', [CategoriaController::class, 'destroy']);


    Route::get('/inventario/compras', [ComprasController::class, 'index'])->name('inventario.compras');
    Route::post('/inventario/compras/store', [ComprasController::class, 'store'])->name('inventario.compras.store');
    Route::get('/inventario/compras/{id}/edit', [ComprasController::class, 'edit'])->name('inventario.compras.edit');
    Route::put('/inventario/compras/{id}/update', [ComprasController::class, 'update'])->name('inventario.compras.update');
    Route::delete('/inventario/compras/destroy/{id}', [ComprasController::class, 'destroy']);
    Route::get('/inventario/compras/list', [ComprasController::class, 'list']);

    Route::get('/ordenes-compra', [OrdenCompraController::class, 'index'])->name('ordenes_compra.index');
    Route::get('/ordenes-compra/list', [OrdenCompraController::class, 'list']);
    Route::post('/ordenes-compra/store', [OrdenCompraController::class, 'store']);
    Route::put('/ordenes-compra/{id}/update', [OrdenCompraController::class, 'update']);
    Route::delete('/ordenes-compra/{id}', [OrdenCompraController::class, 'destroy']);


    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/proveedores/list', [ProveedorController::class, 'list']);
    Route::post('/proveedores/store', [ProveedorController::class, 'store']);
    Route::put('/proveedores/{id}/update', [ProveedorController::class, 'update']);
    Route::delete('/proveedores/{id}', [ProveedorController::class, 'destroy']);

});
