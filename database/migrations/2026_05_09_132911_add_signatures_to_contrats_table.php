<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            // Statuts plus détaillés (Workflow : Brouillon → Envoyé → Signé employeur → Signé employé → Actif)
            // On change le type de la colonne statut si nécessaire ou on l'adapte
            
            $table->timestamp('signed_at_employer')->nullable();
            $table->string('ip_employer', 45)->nullable();
            
            $table->timestamp('signed_at_employee')->nullable();
            $table->string('ip_employee', 45)->nullable();

            $table->timestamp('sent_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            $table->dropColumn(['signed_at_employer', 'ip_employer', 'signed_at_employee', 'ip_employee', 'sent_at']);
        });
    }
};
