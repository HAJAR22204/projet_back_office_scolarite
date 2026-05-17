<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('demandes') && Schema::hasColumn('demandes', 'motif') && !Schema::hasColumn('demandes', 'commentaire')) {
            DB::statement('ALTER TABLE demandes ADD COLUMN commentaire TEXT NULL');
            DB::statement('UPDATE demandes SET commentaire = motif');
            DB::statement('ALTER TABLE demandes DROP COLUMN motif');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('demandes') && Schema::hasColumn('demandes', 'commentaire') && !Schema::hasColumn('demandes', 'motif')) {
            DB::statement('ALTER TABLE demandes ADD COLUMN motif TEXT NULL');
            DB::statement('UPDATE demandes SET motif = commentaire');
            DB::statement('ALTER TABLE demandes DROP COLUMN commentaire');
        }
    }
};
