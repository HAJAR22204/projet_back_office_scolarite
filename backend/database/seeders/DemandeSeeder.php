<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Demande;
use Carbon\Carbon;

class DemandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Demande::create([
            'etudiant_id' => 1,
            'traite_par' => null,
            'date_creation' => Carbon::now()->subDays(2),
            'statut' => 'en_attente',
            'date_traitement' => null,
            'type_document' => 'attestation_scolarité',
            'commentaire' => 'besoin urgent pour dossier de bourse',
            'motif_refus' => null,
            ]);
        Demande::create([
            'etudiant_id' => 2,
            'traite_par' => 2,
            'date_creation' => Carbon::now()->subDays(5),
            'statut' => 'validee',
            'date_traitement' => Carbon::now()->subDays(3),
            'type_document' => 'certificat_scolarité',
            'commentaire' => null,
            'motif_refus' => null,
            ]);
        Demande::create([
            'etudiant_id' => 3,
            'traite_par' => 3,
            'date_creation' => Carbon::now()->subDays(7),
            'statut' => 'refusee',
            'date_traitement' => Carbon::now()->subDays(6),
            'type_document' => 'releve_notes',
            'commentaire' => null,
            'motif_refus' => 'Documents incomplets',
            ]);
        Demande::create([
            'etudiant_id' => 4,
            'traite_par' => 1,
            'date_creation' => Carbon::now()->subDays(1),
            'statut' => 'en_cours',
            'date_traitement' => null,
            'type_document' => 'diplome_deust',
            'commentaire' => 'pour demande de visa etudiant',
            'motif_refus' => null,
            ]);
        Demande::create([
            'etudiant_id' => 5,
            'traite_par' => null,
            'date_creation' => Carbon::now()->subDays(3),
            'statut' => 'en_attente',
            'date_traitement' => null,
            'type_document' => 'retrait_bac',
            'commentaire' => 'besoin pour inscription master',
            'motif_refus' => null,
            ]);
        Demande::create([
            'etudiant_id' => 1,
            'traite_par' => 2,
            'date_creation' => Carbon::now()->subDays(7),
            'statut' => 'validee',
            'date_traitement' => Carbon::now()->subDays(5),
            'type_document' => 'attestation_scolarité',
            'commentaire' => null,
            'motif_refus' => null,
            ]);
        Demande::create([
            'etudiant_id' => 2,
            'traite_par' => 1,
            'date_creation' => Carbon::now()->subDays(4),
            'statut' => 'refusee',
            'date_traitement' => Carbon::now()->subDays(2),
            'type_document' => 'certificat_scolarité',
            'commentaire' => null,
            'motif_refus' => 'Demande non justifiée',
            ]);
    }
}
