<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modifier l'ENUM pour ajouter maternite et paternite
        DB::statement("ALTER TABLE conges MODIFY COLUMN type_conge ENUM('annuel','maladie','maternite','paternite','sans_solde') DEFAULT 'annuel'");
        
        Schema::table('conges', function (Blueprint $table) {
            $table->foreignId('valide_par')->nullable()->after('statut')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('conges', function (Blueprint $table) {
            $table->dropForeign(['valide_par']);
            $table->dropColumn('valide_par');
        });
        DB::statement("ALTER TABLE conges MODIFY COLUMN type_conge ENUM('annuel','maladie','sans_solde') DEFAULT 'annuel'");
    }
};
