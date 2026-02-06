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
        Schema::create('rpjm', function (Blueprint $table) {
            $table->id('id_rpjm');
            $table->string('visi');
            $table->text('misi');
            $table->year('tahun_mulai');
            $table->year('tahun_selesai');
            $table->string('file_dokumen')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rpjm');
    }
};
