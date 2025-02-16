<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public function index()
    {
        return view('proveedores.index');
    }

    public function list()
    {
        return response()->json(Proveedor::latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:proveedores',
            'email' => 'required|email|unique:proveedores',
            'telefono' => 'nullable|digits_between:7,15',
            'contacto' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        Proveedor::create($request->all());

        return response()->json(['success' => 'Proveedor agregado correctamente']);
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $request->validate([
            'nombre' => 'required|unique:proveedores,nombre,' . $id,
            'email' => 'required|email|unique:proveedores,email,' . $id,
            'telefono' => 'nullable|digits_between:7,15',
            'contacto' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        $proveedor->update($request->all());

        return response()->json(['success' => 'Proveedor actualizado correctamente']);
    }

    public function destroy($id)
    {
        Proveedor::destroy($id);

        return response()->json(['message' => 'Proveedor eliminado con éxito']);
    }
}
