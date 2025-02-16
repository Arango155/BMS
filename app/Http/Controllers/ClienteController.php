<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_documento' => 'required|string',
            'documento' => 'required|string|unique:clientes',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'estado_residencia' => 'nullable|string',
            'ciudad' => 'nullable|string',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:clientes'
        ]);

        Cliente::create($request->all());

        return response()->json(['message' => 'Cliente agregado correctamente']);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'tipo_documento' => 'required|string',
            'documento' => 'required|string|unique:clientes,documento,' . $id,
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'estado_residencia' => 'nullable|string',
            'ciudad' => 'nullable|string',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:clientes,email,' . $id
        ]);

        $cliente->update($request->all());

        return response()->json(['message' => 'Cliente actualizado correctamente']);
    }

    public function destroy($id)
    {
        Cliente::findOrFail($id)->delete();

        return response()->json(['message' => 'Cliente eliminado correctamente']);
    }
}
