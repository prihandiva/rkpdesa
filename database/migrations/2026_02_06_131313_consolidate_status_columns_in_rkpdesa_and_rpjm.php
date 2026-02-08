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
        Schema::table('rkpdesa', function (Blueprint $table) {
            $table->dropColumn(['status_verifikasi', 'status_approval']);
            // status column already exists in rkpdesa, ensure it's varchar/string if needed, but dropColumn is minimal.
        });

        Schema::table('rpjm', function (Blueprint $table) {
            $table->string('status')->nullable()->default('Proses')->after('file_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rkpdesa', function (Blueprint $table) {
            $table->string('status_verifikasi')->nullable();
            $table->string('status_approval')->nullable();
        });

        Schema::table('rpjm', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
