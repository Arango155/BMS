<?php




namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;
use App\Models\User;

class SwitchDatabase
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // 🔹 Asegurar que el usuario tiene empresa
            if ($user->empresa_id) {
                $empresa = Empresa::find($user->empresa_id);

                if ($empresa && $empresa->db_name) {
                    // 🔄 Configurar conexión al tenant
                    Config::set('database.connections.tenant.database', $empresa->db_name);
                    DB::purge('tenant');
                    DB::reconnect('tenant');

                    // 🔄 Recargar usuario desde la base de datos `tenant`
                    $tenantUser = User::on('tenant')->where('email', $user->email)->first();
                    if ($tenantUser) {
                        Auth::setUser($tenantUser);
                        session(['tenant_user' => $tenantUser]); // Almacenar en sesión
                    }
                }
            }
        }

        return $next($request);
    }
}
