<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;
use App\Models\User;


class EnsureOnboardingIsCompleteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // 🔹 **Volver a obtener los datos del usuario desde la base de datos**
            $user = User::where('id', $user->id)->first();
            Auth::setUser($user);

            \Log::info('Middleware EnsureOnboardingIsComplete:', [
                'user_id' => $user->id,
                'onboarding_completo' => $user->onboarding_completo,
                'empresa_id' => $user->empresa_id,
            ]);

            if (!$user->empresa_id || !$user->onboarding_completo) {
                return redirect()->route('onboarding');
            }

            // Cargar la empresa correctamente
            $empresa = Empresa::where('id', $user->empresa_id)->first();
            if ($empresa && $empresa->db_name) {
                Config::set('database.connections.tenant.database', $empresa->db_name);
                DB::purge('tenant');
                DB::reconnect('tenant');

                Auth::setUser($user);
            }
        }

        return $next($request);
    }

}
