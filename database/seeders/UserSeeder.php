<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Jesus Rojas',
                'email' => 'admin@admin.com',
                'password' => bcrypt('12345678'),
                'roles_id' => 1,
            ],
            [
                'name' => 'Test Rojas',
                'email' => 'test@test.com',
                'password' => bcrypt('12345678'),
                'roles_id' => 2,
            ]
        ];

        foreach ($users as $value) {
            User::create([
                'name' => $value['name'],
                'email' => $value['email'],
                'password' => $value['password'],
                'roles_id' => $value['roles_id'],
            ]);
        }
    }
}
