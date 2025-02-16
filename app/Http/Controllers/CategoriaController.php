<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    public function list()
    {
        try {
            // Obtener todas las categorías del tenant
            $categorias = DB::connection('tenant')->table('categorias')->latest()->get();
            return response()->json($categorias, 200);
        } catch (\Exception $e) {
            Log::error('❌ Error al obtener las categorías:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al obtener las categorías'], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('📌 Datos recibidos en store:', $request->all());

        $request->validate([
            'nombre' => 'required|unique:categorias',
            'ubicacion' => 'nullable|string',
            'estado' => 'required|string',
            'productos' => 'nullable|integer',
        ]);

        Log::info('✅ Validación pasada.');

        try {
            DB::connection('tenant')->table('categorias')->insert([
                'nombre' => $request->nombre,
                'ubicacion' => $request->ubicacion,
                'estado' => $request->estado,
                'productos' => $request->productos ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('✅ Categoría guardada en la base de datos.');
            return response()->json(['success' => 'Categoría agregada correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('❌ Error al guardar la categoría:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al guardar la categoría'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info("📌 Datos recibidos para actualizar la categoría con ID: {$id}", $request->all());

        $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $id,
            'ubicacion' => 'nullable|string',
            'estado' => 'required|string',
            'productos' => 'nullable|integer',
        ]);

        try {
            // Verificar si la categoría existe
            $categoria = DB::connection('tenant')->table('categorias')->where('id', $id)->first();

            if (!$categoria) {
                return response()->json(['error' => 'Categoría no encontrada'], 404);
            }

            // Actualizar la categoría
            DB::connection('tenant')->table('categorias')->where('id', $id)->update([
                'nombre' => $request->nombre,
                'ubicacion' => $request->ubicacion,
                'estado' => $request->estado,
                'productos' => $request->productos,
                'updated_at' => now(),
            ]);

            Log::info("✅ Categoría con ID: {$id} actualizada correctamente.");
            return response()->json(['success' => 'Categoría actualizada correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('❌ Error al actualizar la categoría:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al actualizar la categoría'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::connection('tenant')->table('categorias')->where('id', $id)->delete();
            return response()->json(['message' => 'Categoría eliminada con éxito'], 200);
        } catch (\Exception $e) {
            Log::error('❌ Error al eliminar la categoría:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al eliminar la categoría'], 500);
        }
    }
}
