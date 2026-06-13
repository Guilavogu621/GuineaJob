<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table des Appels d'Offres (Les besoins publiés par les entreprises)
        Schema::create('appels_offres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->string('secteur_activite')->index();
            $table->string('budget_estime')->nullable(); // Ex: "50M - 100M GNF"
            $table->string('lieu_execution')->nullable();
            $table->date('date_limite');
            $table->string('document_cctp')->nullable(); // Cahier des Charges
            $table->enum('statut', ['publie', 'cloture', 'attribue', 'annule'])->default('publie');
            $table->integer('vues')->default(0);
            $table->timestamps();
        });

        // Table des Propositions (Les réponses des entreprises prestataires)
        Schema::create('propositions_offres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appel_offre_id')->constrained('appels_offres')->onDelete('cascade');
            $table->foreignId('entreprise_prestataire_id')->constrained('entreprises')->onDelete('cascade');
            $table->decimal('montant_propose', 15, 2);
            $table->string('delai_execution'); // Ex: "3 mois"
            $table->text('message_accompagnement')->nullable();
            $table->string('document_proposition')->nullable(); // Devis/Mémoire technique
            $table->enum('statut', ['en_attente', 'en_examen', 'retenu', 'rejete'])->default('en_attente');
            $table->text('note_interne')->nullable(); // Notes de l'émetteur
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('propositions_offres');
        Schema::dropIfExists('appels_offres');
    }
};
