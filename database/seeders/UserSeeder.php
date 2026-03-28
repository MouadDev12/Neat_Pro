<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@demo.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Manager User',
            'email'    => 'manager@demo.com',
            'password' => bcrypt('password'),
            'role'     => 'manager',
        ]);

        User::factory(8)->create(['role' => 'user']);
    }
}
