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
        Schema::table('rpjm', function (Blueprint $table) {
            $table->string('bidang')->nullable();
            $table->string('subbidang')->nullable();
            $table->string('jenis_kegiatan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('volume')->nullable();
            $table->string('sasaran')->nullable();
            $table->string('waktu')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('sumber_dana')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpjm', function (Blueprint $table) {
            $table->dropColumn([
                'bidang',
                'subbidang',
                'jenis_kegiatan',
                'lokasi',
                'volume',
                'sasaran',
                'waktu',
                'jumlah',
                'sumber_dana'
            ]);
        });
    }
};
