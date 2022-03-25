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
        //
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
