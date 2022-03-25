<?php

namespace Database\Seeders;

use App\Models\IngredientePizza;
use Illuminate\Database\Seeder;

class IngredientePizzaSeeder extends Seeder
{
    public function run()
    {
        /* Ingredintes List:
            1 Agua
            2 Harina
            3 Sal
            4 Levadura
            5 Aceite de Oliva
            6 Tomate
            7 Albahaca
            8 Queso
        */
        $marinara = [
            'pizzas_id' => 1,
            'ingredientes' => [
                1,
                2,
                3,
                4,
                8,
            ]
        ];
        $margherita = [
            'pizzas_id' => 2,
            'ingredientes' => [
                1,
                2,
                3,
                4,
                8,
                7,
            ]
        ];
        $sfincione = [
            'pizzas_id' => 3,
            'ingredientes' => [
                1,
                2,
                3,
                4,
                8,
                6,
            ]
        ];
        $fugazza = [
            'pizzas_id' => 4,
            'ingredientes' => [
                1,
                2,
                3,
                4,
                8,
                5,
            ]
        ];
        $flammkuchen = [
            'pizzas_id' => 5,
            'ingredientes' => [
                1,
                2,
                3,
                4,
                5,
                6,
                8,
            ]
        ];

        $pizzas = [$marinara,$margherita,$sfincione,$fugazza,$flammkuchen];
        
        foreach ($pizzas as $value) {
            foreach ($value['ingredientes'] as $iterar) {
                IngredientePizza::create([
                    'pizzas_id' => $value['pizzas_id'],
                    'ingredientes_id' => $iterar,
                ]);
            }
        }
    }
}
