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
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->string('asal_pemimpin')->after('pemimpin')->nullable();
            $table->string('asal_notulis1')->after('notulis1')->nullable();
            $table->string('asal_notulis2')->after('notulis2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->dropColumn(['asal_pemimpin', 'asal_notulis1', 'asal_notulis2']);
        });
    }
};
