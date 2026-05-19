<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use Illuminate\Database\Seeder;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Etudiant::create([
            'cne' => 'R123456789',
            'code_apogee' => '21001234',
            'nom' => 'Idrissi',
            'prenom' => 'Amina',
        ]);
        Etudiant::create([
            'cne' => 'R987654321',
            'code_apogee' => '21005678',
            'nom' => 'El Fassi',
            'prenom' => 'Youssef',
        ]);
        Etudiant::create([
            'cne' => 'R456789123',
            'code_apogee' => '21002345',
            'nom' => 'Bennani',
            'prenom' => 'Sara',
        ]);
        Etudiant::create([
            'cne' => 'R654321987',
            'code_apogee' => '21006789',
            'nom' => 'Chafik',
            'prenom' => 'Omar',
        ]);
        Etudiant::create([
            'cne' => 'R321654987',
            'code_apogee' => '21003456',
            'nom' => 'Zahraoui',
            'prenom' => 'Laila',
        ]);
    }
}
