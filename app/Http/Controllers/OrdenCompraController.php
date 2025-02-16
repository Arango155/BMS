<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrdenCompra;

class OrdenCompraController extends Controller
{
    public function index()
    {
        return view('ordenes_compra.index');
    }

    public function list()
    {
        return response()->json(OrdenCompra::latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_orden' => 'required|unique:ordenes_compra',
            'proveedor' => 'required',
            'monto_total' => 'required|numeric',
            'fecha' => 'required|date',
            'estado' => 'required'
        ]);

        OrdenCompra::create($request->all());

        return response()->json(['success' => 'Orden de compra agregada correctamente']);
    }

    public function update(Request $request, $id)
    {
        $orden = OrdenCompra::findOrFail($id);

        $request->validate([
            'numero_orden' => 'required|unique:ordenes_compra,numero_orden,' . $id,
            'proveedor' => 'required',
            'monto_total' => 'required|numeric',
            'fecha' => 'required|date',
            'estado' => 'required'
        ]);

        $orden->update($request->all());

        return response()->json(['success' => 'Orden de compra actualizada correctamente']);
    }

    public function destroy($id)
    {
        OrdenCompra::destroy($id);

        return response()->json(['message' => 'Orden de compra eliminada con éxito']);
    }
}
