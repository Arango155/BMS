<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Inertia::share([
            'auth' => function () {
                if (Auth::check()) {
                    return [
                        'user' => Auth::user()->only(['id', 'name', 'email', 'onboarding_completo']),
                        'profile' => Auth::user()->profile ? Auth::user()->profile->only([
                            'dashboard_name',
                            'empresa_tipo',
                            'empresa_nombre',
                            'modulos',
                            'onboarding_completo',
                        ]) : null,

                    ];
                }
                return null;
            },
        ]);
    }

}
