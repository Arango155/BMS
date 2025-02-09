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

            if (!$user->empresa_id || !$user->onboarding_completo) {
                return redirect()->route('onboarding');
            }

            // 🔄 Cargar la empresa
            $empresa = Empresa::find($user->empresa_id);
            if ($empresa && $empresa->db_name) {
                // 🔄 Cambiar a la base de datos correcta
                Config::set('database.connections.tenant.database', $empresa->db_name);
                DB::purge('tenant');
                DB::reconnect('tenant');

                // 🔄 Recargar el usuario en la base de datos tenant
                $tenantUser = User::on('tenant')->where('email', $user->email)->first();
                if ($tenantUser) {
                    Auth::setUser($tenantUser);
                    session(['tenant_user' => $tenantUser]); // Guardar usuario en sesión
                }
            }
        }

        return $next($request);
    }
}
