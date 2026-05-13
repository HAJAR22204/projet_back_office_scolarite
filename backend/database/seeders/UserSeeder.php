<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nom' => 'hajar',
            'prenom' => 'zegour',
            'email' => 'hajarzegour22@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'chefScolarite',
        ]);

        User::create([
            'nom' => 'haj',
            'prenom' => 'zeg',
            'email' => 'h.zegour9169@uca.ac.ma',
            'password' => Hash::make('password'),
            'role' => 'agentScolarite',
        ]);

    
    }
}