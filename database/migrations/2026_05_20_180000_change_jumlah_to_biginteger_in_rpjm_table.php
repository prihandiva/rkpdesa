<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah kolom 'jumlah' dari integer menjadi bigInteger
     * agar dapat menampung nilai anggaran yang lebih besar (hingga ~9,2 kuintiliun).
     * integer  : maks  2.147.483.647  (~2,1 miliar)
     * bigInteger: maks  9.223.372.036.854.775.807 (~9,2 kuintiliun)
     */
    public function up(): void
    {
        Schema::table('rpjm', function (Blueprint $table) {
            $table->bigInteger('jumlah')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpjm', function (Blueprint $table) {
            $table->integer('jumlah')->nullable()->change();
        });
    }
};
