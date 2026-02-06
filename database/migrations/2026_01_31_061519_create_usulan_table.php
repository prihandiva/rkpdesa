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
        Schema::create('usulan', function (Blueprint $table) {
            $table->id('id_usulan');
            $table->string('jenis_kegiatan')->nullable();
            $table->string('id_dusun')->nullable();
            $table->string('id_rw')->nullable();
            $table->string('id_rt')->nullable();
            $table->integer('prioritas')->nullable();
            $table->string('status')->nullable();
            $table->string('tahun')->nullable();
            $table->string('file_berita_acara')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan');
    }
};
