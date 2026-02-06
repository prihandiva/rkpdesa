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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama')->nullable();
            $table->string('role')->nullable();
            $table->string('telp')->nullable();
            $table->string('id_dusun')->nullable();
            $table->string('id_rw')->nullable();
            $table->string('id_rt')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->longText('profile_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
