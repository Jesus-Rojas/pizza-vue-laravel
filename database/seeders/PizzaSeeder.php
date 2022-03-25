<?php

namespace Database\Seeders;

use App\Models\Pizza;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    public function run()
    {
        $marinara = [
            'nombre' => 'La Marinara',
            'precio' => 2000,
            'cantidad' => 1,
        ];
        $margherita = [
            'nombre' => 'La Margherita',
            'precio' => 2000,
            'cantidad' => 1,
        ];
        $sfincione = [
            'nombre' => 'La Sfincione',
            'precio' => 2000,
            'cantidad' => 1,
        ];
        $fugazza = [
            'nombre' => 'La Fugazza',
            'precio' => 2000,
            'cantidad' => 1,
        ];
        $flammkuchen = [
            'nombre' => 'La Flammkuchen',
            'precio' => 2000,
            'cantidad' => 1,
        ];
        $pizzas = [$marinara, $margherita, $sfincione, $fugazza, $flammkuchen];
        foreach ($pizzas as $value) {
            Pizza::create([
                'nombre' => $value['nombre'],
                'precio' => $value['precio'],
                'stock' => $value['cantidad'],
            ]);
        }
    }
}
