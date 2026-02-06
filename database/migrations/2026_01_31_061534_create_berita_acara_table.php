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
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id('id_berita');
            $table->string('id_tahun')->nullable();
            $table->string('id_dusun')->nullable();
            $table->string('hari')->nullable();
            $table->timestamp('tanggal')->nullable();
            $table->string('tempat')->nullable();
            $table->string('materi')->nullable();
            $table->string('pemimpin')->nullable();
            $table->string('notulis1')->nullable();
            $table->string('notulis2')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
