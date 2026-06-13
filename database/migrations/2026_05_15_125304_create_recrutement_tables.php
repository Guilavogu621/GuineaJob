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
        // Table des offres d'emploi
        Schema::create('offres_emploi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->text('competences_requises')->nullable();
            $table->string('lieu')->default('Conakry');
            $table->string('type_contrat'); // CDI, CDD, Stage, Prestation
            $table->string('salaire_range')->nullable(); // Ex: 5M - 8M GNF
            $table->date('date_expiration')->nullable();
            $table->enum('statut', ['brouillon', 'publiee', 'archivee', 'cloturee'])->default('brouillon');
            $table->integer('vues')->default(0);
            $table->timestamps();
        });

        // Table des candidatures
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offre_emploi_id')->constrained('offres_emploi')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Le candidat
            $table->string('cv_path');
            $table->string('lettre_motivation_path')->nullable();
            $table->text('commentaire_candidat')->nullable();
            $table->enum('statut', ['en_attente', 'retenu', 'rejete', 'entretien', 'embauche'])->default('en_attente');
            $table->text('note_employeur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
        Schema::dropIfExists('offres_emploi');
    }
};
