<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // On modifie la colonne pour qu'elle soit de type VARCHAR (string) au lieu de ENUM
        DB::statement("ALTER TABLE employes MODIFY type_contrat VARCHAR(255) DEFAULT 'CDI'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // En cas d'annulation, on remet l'ENUM tel qu'il était
        DB::statement("ALTER TABLE employes MODIFY type_contrat ENUM('CDI', 'CDD') DEFAULT 'CDI'");
    }
};
