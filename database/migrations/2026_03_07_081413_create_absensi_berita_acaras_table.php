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
        Schema::create('absensi_berita_acara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_berita')->constrained('berita_acara', 'id_berita')->onDelete('cascade');
            $table->string('nama');
            $table->string('alamat')->nullable();
            $table->string('unsur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_berita_acara');
    }
};
