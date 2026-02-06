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
        Schema::table('usulan', function (Blueprint $table) {
            // Ensure combination of Dusun, Prioritas, and Tahun is unique
            $table->unique(['id_dusun', 'prioritas', 'tahun'], 'usulan_priority_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usulan', function (Blueprint $table) {
            $table->dropUnique('usulan_priority_unique');
        });
    }
};
