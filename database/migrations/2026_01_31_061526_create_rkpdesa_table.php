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
        Schema::create('rkpdesa', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->string('nama')->nullable();
            $table->string('bidang')->nullable();
            $table->string('jenis_kegiatan')->nullable();
            $table->text('data_existing')->nullable();
            $table->text('target_capaian')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('volume')->nullable();
            $table->string('penerima')->nullable();
            $table->string('waktu')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('sumber_biaya')->nullable();
            $table->string('pola_pelaksanaan')->nullable();
            $table->string('status')->nullable();
            $table->string('tahun')->nullable();
            $table->foreignId('id_rpjm')->nullable();
            $table->foreignId('id_usulan')->nullable();
            $table->string('status_verifikasi')->default('pending'); // pending, diterima, ditolak, revisi
            $table->text('catatan_verifikasi')->nullable();
            $table->string('status_approval')->default('pending'); // pending, disetujui, ditolak
            $table->string('file_berita_acara_musrenbang')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkpdesa');
    }
};
