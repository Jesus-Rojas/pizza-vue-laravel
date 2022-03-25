<?php

namespace Database\Seeders;

use App\Models\Ingrediente;
use Illuminate\Database\Seeder;

class IngredienteSeeder extends Seeder
{
    public function run()
    {
        $ingredientes = [
            'Agua',
            'Harina',
            'Sal',
            'Levadura',
            'Aceite de Oliva',
            'Tomate',
            'Albahaca',
            'Queso',
        ];
        foreach ($ingredientes as $value) {
            Ingrediente::create([
                'nombre' => $value
            ]);
        }
    }
}
