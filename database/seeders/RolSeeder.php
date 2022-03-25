<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'Admin',
            'Cliente'
        ];
        foreach ($roles as $value) {
            Rol::create([
                'nombre' => $value
            ]);
        }
    }
}
