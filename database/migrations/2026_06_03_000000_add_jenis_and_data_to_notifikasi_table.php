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
        Schema::table('notifikasi', function (Blueprint $table) {
            // Add 'jenis' column if it doesn't exist
            if (!Schema::hasColumn('notifikasi', 'jenis')) {
                $table->string('jenis')->nullable()->after('id_notif');
            }
            
            // Add 'data' column for storing JSON data (e.g., WhatsApp send results)
            if (!Schema::hasColumn('notifikasi', 'data')) {
                $table->json('data')->nullable()->after('dibaca');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            if (Schema::hasColumn('notifikasi', 'jenis')) {
                $table->dropColumn('jenis');
            }
            if (Schema::hasColumn('notifikasi', 'data')) {
                $table->dropColumn('data');
            }
        });
    }
};
