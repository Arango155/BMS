<?php

// app/Http/Controllers/CajaController.php
namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CajaController extends Controller
{
    public function index()
    {
        $cajas = Caja::all();
        return Inertia::render('Inventario/Caja', compact('cajas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|unique:cajas',
            'nombre' => 'required',
            'efectivo' => 'required|numeric',
            'estado' => 'required',
        ]);

        Caja::create($request->all());

        return Redirect::route('inventario.Caja');
    }

    public function edit($id)
    {
        $caja = Caja::findOrFail($id);
        return Inertia::render('Inventario/CajaEdit', compact('caja'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero' => 'required',
            'nombre' => 'required',
            'efectivo' => 'required|numeric',
            'estado' => 'required',
        ]);

        $caja = Caja::findOrFail($id);
        $caja->update($request->all());

        return Redirect::route('inventario.Caja');
    }
public function destroy($id)
{
    $caja = Caja::findOrFail($id);
    $caja->delete();

    return response()->json(['message' => 'Caja eliminada con éxito']);
}

}
