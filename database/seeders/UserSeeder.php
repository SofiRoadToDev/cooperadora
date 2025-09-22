<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Usuario Uno',
            'username' => 'usuario1',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Usuario Dos',
            'username' => 'usuario2',
            'password' => Hash::make('password'),
        ]);
    }
}
