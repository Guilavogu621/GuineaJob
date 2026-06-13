<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fiche_paies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            $table->foreignId('contrat_id')->constrained()->onDelete('cascade');
            $table->date('mois'); // CDC: mois DATE NN
            $table->decimal('salaire_brut', 12, 2);
            $table->decimal('cnss', 12, 2)->default(0);       // CDC: CNSS 5%
            $table->decimal('aguipe', 12, 2)->default(0);      // CDC: AGUIPE 1%
            $table->decimal('autres_deductions', 12, 2)->default(0);
            $table->decimal('salaire_net', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fiche_paies');
    }
};
