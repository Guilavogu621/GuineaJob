<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Mise à jour de la table Users
        Schema::table('users', function (Blueprint $table) {
            $table->string('nom')->after('id')->nullable();
            $table->string('prenom')->after('nom')->nullable();
            $table->enum('role', ['admin', 'employeur', 'employe', 'candidat', 'prestataire'])->default('candidat')->after('password');
            $table->boolean('must_change_password')->default(false)->after('role');
            // Suppression sécurisée de 'name' s'il existe
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
        });

        // 2. Table Entreprises (Employeurs)
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('raison_sociale', 150)->unique();
            $table->string('secteur')->nullable();
            $table->text('adresse')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('site_web')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        // 3. Table Employés (Liés aux entreprises)
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('entreprise_id')->constrained()->onDelete('cascade');
            $table->string('numero_matricule', 50)->unique();
            $table->string('poste', 150);
            $table->date('date_embauche');
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->enum('genre', ['Masculin', 'Féminin'])->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->enum('type_contrat', ['CDI', 'CDD', 'Stage', 'Prestation'])->default('CDI');
            $table->decimal('salaire_base', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employes');
        Schema::dropIfExists('entreprises');
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id')->nullable();
            }
            $table->dropColumn(['nom', 'prenom', 'role', 'must_change_password']);
        });
    }
};
