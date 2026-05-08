<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            $table->string('statut', 30)->change();
        });
    }

    public function down(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            // Pas besoin de revenir en enum car string est plus large
        });
    }
};
