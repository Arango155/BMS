<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class EmpresaController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:empresas',
        ]);

        // Crear la empresa en la base de datos principal
        $empresa = Empresa::create([
            'nombre' => $request->nombre,
            'db_name' => 'erp_' . strtolower($request->nombre),
        ]);

        // Crear la base de datos específica para la empresa
        DB::statement("CREATE DATABASE IF NOT EXISTS {$empresa->db_name}");

        // Configurar la conexión al tenant (empresa)
        config(['database.connections.tenant.database' => $empresa->db_name]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Ejecutar migraciones para la nueva base de datos de la empresa
        Artisan::call('tenant:migrate', ['db_name' => $empresa->db_name]);

        return response()->json(['message' => 'Empresa creada con éxito', 'empresa' => $empresa]);
    }
}

