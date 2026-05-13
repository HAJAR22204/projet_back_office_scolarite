<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->string('cne', 20);
            $table->integer('code_apogee');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 100);
            $table->foreignId('traite_par')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('date_creation');
            $table->enum('statut', ['en_attente', 'en_cours', 'prete', 'refusee'])->default('en_attente');
            $table->dateTime('date_traitement')->nullable();
            $table->enum('type_document', ['attestation_inscription', 'certificat_scolarite', 'releve_notes', 'diplome_deust', 'retrait_bac']);
            $table->integer('semestre')->nullable();
            $table->enum('type_retrait', ['temporaire', 'definitif'])->nullable();
            $table->text('commentaire')->nullable();
            $table->text('motif_refus')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};