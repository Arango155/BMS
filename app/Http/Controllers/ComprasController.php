<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class ComprasController extends Controller
{
    public function index()
    {
        $compras = DB::connection('tenant')->table('compras')->latest()->get();
        return Inertia::render('Inventario/Compras', ['compras' => $compras]);
    }

    public function list()
    {
        try {
            $compras = DB::connection('tenant')->table('compras')->latest()->get();
            return response()->json($compras, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las compras'], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('📌 Datos recibidos en store:', $request->all());

        $request->validate([
            'proveedor' => 'required',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'estado' => 'required',
        ]);

        Log::info('✅ Validación pasada.');

        try {
            DB::connection('tenant')->table('compras')->insert([
                'proveedor' => $request->proveedor,
                'monto' => $request->monto,
                'fecha' => $request->fecha,
                'estado' => $request->estado,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('✅ Compra guardada en la base de datos.');
            return response()->json(['success' => 'Compra agregada correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('❌ Error al guardar la compra:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al guardar la compra'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info("📌 Datos recibidos para actualizar la compra con ID: {$id}", $request->all());

        $request->validate([
            'proveedor' => 'required',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'estado' => 'required',
        ]);

        try {
            $compra = DB::connection('tenant')->table('compras')->where('id', $id)->first();

            if (!$compra) {
                return response()->json(['error' => 'Compra no encontrada'], 404);
            }

            DB::connection('tenant')->table('compras')->where('id', $id)->update([
                'proveedor' => $request->proveedor,
                'monto' => $request->monto,
                'fecha' => $request->fecha,
                'estado' => $request->estado,
                'updated_at' => now(),
            ]);

            Log::info("✅ Compra con ID: {$id} actualizada correctamente.");
            return response()->json(['success' => 'Compra actualizada correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('❌ Error al actualizar la compra:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al actualizar la compra'], 500);
        }
    }

    public function destroy($id)
    {
        DB::connection('tenant')->table('compras')->where('id', $id)->delete();
        return response()->json(['message' => 'Compra eliminada con éxito']);
    }
}
