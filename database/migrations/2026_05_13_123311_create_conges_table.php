<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            $table->enum('type_conge', ['annuel', 'maladie', 'sans_solde'])->default('annuel');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->decimal('jours_deduits', 5, 2)->default(0); // Permet des demi-journées
            $table->text('motif')->nullable();
            $table->enum('statut', ['en_attente', 'valide', 'refuse'])->default('en_attente');
            $table->text('reponse_employeur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
