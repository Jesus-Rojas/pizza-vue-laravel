<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    public function index()
    {
        return response()->json(Ingrediente::paginate());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required',
            ]);
            // return response()->json($request->all());
            $ingrediente = Ingrediente::create([
                'nombre' => $request['nombre']
            ]);
    
            if ($ingrediente->save()) {
                return response()->json([
                    'mensaje' => 'Se creo registro con exito',
                    'status' => 'ok'
                ]);
            }
    
            return response()->json([
                'mensaje' => 'problemas en el servidor verificar',
                'status' => 'bad'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function show(Ingrediente $ingrediente)
    {
        //
    }

    public function edit(Ingrediente $ingrediente)
    {
        //
    }

    public function update(Request $request, Ingrediente $ingrediente)
    {
        //
    }

    public function destroy(Ingrediente $ingrediente)
    {
        //
    }
}
