<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            $table->string('type_resiliation')->nullable()->after('statut'); // Licenciement, Démission, Accord, Fin normale, etc.
            $table->text('motif_resiliation')->nullable()->after('type_resiliation');
            $table->date('date_resiliation')->nullable()->after('motif_resiliation');
            $table->timestamp('resilie_at')->nullable()->after('date_resiliation');
        });
    }

    public function down(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            $table->dropColumn(['type_resiliation', 'motif_resiliation', 'date_resiliation', 'resilie_at']);
        });
    }
};
