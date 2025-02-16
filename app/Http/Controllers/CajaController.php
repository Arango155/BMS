<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CajaController extends Controller
{
    public function index()
    {
        // Obtener todas las cajas del tenant
        $cajas = DB::connection('tenant')->table('cajas')->latest()->get();

        return Inertia::render('Inventario/Caja', ['cajas' => $cajas]);
    }

    public function list()
    {
        try {
            // Obtener todas las cajas del tenant
            $cajas = DB::connection('tenant')->table('cajas')->latest()->get();
            return response()->json($cajas, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las cajas'], 500);
        }
    }



    public function store(Request $request)
    {
        \Log::info('📌 Datos recibidos en store:', $request->all());

        $request->validate([
            'numero' => 'required|unique:cajas',
            'nombre' => 'required',
            'efectivo' => 'required|numeric',
            'estado' => 'required',
        ]);

        \Log::info('✅ Validación pasada.');

        try {
            DB::connection('tenant')->table('cajas')->insert([
                'numero' => $request->numero,
                'nombre' => $request->nombre,
                'efectivo' => $request->efectivo,
                'estado' => $request->estado,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \Log::info('✅ Caja guardada en la base de datos.');

            return response()->json(['success' => 'Caja agregada correctamente'], 200);
        } catch (\Exception $e) {
            \Log::error('❌ Error al guardar la caja:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al guardar la caja'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        \Log::info("📌 Datos recibidos para actualizar la caja con ID: {$id}", $request->all());

        // Validación de los datos
        $request->validate([
            'numero' => 'required|unique:cajas,numero,' . $id, // Permitir mismo número si es el mismo ID
            'nombre' => 'required',
            'efectivo' => 'required|numeric',
            'estado' => 'required',
        ]);

        try {
            // Verificar si la caja existe
            $caja = DB::connection('tenant')->table('cajas')->where('id', $id)->first();

            if (!$caja) {
                return response()->json(['error' => 'Caja no encontrada'], 404);
            }

            // Actualizar la caja
            DB::connection('tenant')->table('cajas')->where('id', $id)->update([
                'numero' => $request->numero,
                'nombre' => $request->nombre,
                'efectivo' => $request->efectivo,
                'estado' => $request->estado,
                'updated_at' => now(),
            ]);

            \Log::info("✅ Caja con ID: {$id} actualizada correctamente.");
            return response()->json(['success' => 'Caja actualizada correctamente'], 200);
        } catch (\Exception $e) {
            \Log::error('❌ Error al actualizar la caja:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al actualizar la caja'], 500);
        }
    }


    public function destroy($id)
    {
        DB::connection('tenant')->table('cajas')->where('id', $id)->delete();
        return response()->json(['message' => 'Caja eliminada con éxito']);
    }
}
