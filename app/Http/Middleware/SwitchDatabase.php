<?php



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SwitchDatabase
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $empresa = $user->empresa;

            if ($empresa && $empresa->db_name) {
                Config::set('database.connections.tenant.database', $empresa->db_name);
                DB::purge('tenant');
                DB::reconnect('tenant');

                // Actualizar la sesión y usuario
                Auth::setUser($user);
            }
        }

        return $next($request);
    }


}
