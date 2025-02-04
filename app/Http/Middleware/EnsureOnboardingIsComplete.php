<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOnboardingIsComplete
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->onboarding_completo) {
            return redirect()->route('onboarding'); // Redirigir si no ha completado el onboarding
        }

        return $next($request);
    }
}
