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
            $table->dropColumn([
                'visi',
                'misi',
                'tahun_mulai',
                'tahun_selesai',
                'file_dokumen'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpjm', function (Blueprint $table) {
            $table->string('visi');
            $table->text('misi');
            $table->year('tahun_mulai');
            $table->year('tahun_selesai');
            $table->string('file_dokumen')->nullable();
        });
    }
};
