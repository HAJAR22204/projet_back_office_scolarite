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
            'nom' => 'Bennani',
            'prenom' => 'Mohammed',
            'email' => 'chef@scolarite.ma',
            'password' => Hash::make('password'),
            'role' => 'chefScolarite',
        ]);

        User::create([
            'nom' => 'Alami',
            'prenom' => 'Fatima',
            'email' => 'agent1@scolarite.ma',
            'password' => Hash::make('password'),
            'role' => 'agentScolarite',
        ]);

        User::create([
            'nom' => 'Tazi',
            'prenom' => 'Omar',
            'email' => 'agent2@scolarite.ma',
            'password' => Hash::make('password'),
            'role' => 'agentScolarite',
        ]);
    }
}