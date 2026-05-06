<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            $table->foreignId('entreprise_id')->constrained()->onDelete('cascade');
            $table->string('numero_contrat')->unique();
            $table->enum('type_contrat', ['CDI', 'CDD', 'Stage', 'Prestation']);
            $table->date('date_debut');
            $table->date('date_fin')->nullable(); // Optionnel pour CDI
            $table->string('periode_essai')->nullable();
            $table->decimal('salaire_mensuel_brut', 15, 2);
            $table->text('clauses_specifiques')->nullable();
            $table->enum('statut', ['Brouillon', 'Actif', 'Terminé', 'Annulé'])->default('Brouillon');
            $table->string('document_path')->nullable(); // Pour le PDF généré
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
