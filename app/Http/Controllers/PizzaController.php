<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function index()
    {
        return response()->json(Pizza::with('ingrediente_pizzas.ingredientes')->paginate(10));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Pizza $pizza)
    {
        //
    }

    public function edit(Pizza $pizza)
    {
        //
    }

    public function update(Request $request, Pizza $pizza)
    {
        //
    }

    public function destroy(Pizza $pizza)
    {
        //
    }
}
