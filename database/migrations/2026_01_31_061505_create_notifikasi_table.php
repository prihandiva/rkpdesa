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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notif');
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('id_kegiatan')->nullable();
            $table->string('judul_kegiatan')->nullable();
            $table->string('status')->nullable();
            $table->string('id_penerima')->nullable();
            $table->integer('dibaca')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
