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
            // New columns
            if (!Schema::hasColumn('berita_acara', 'jenis')) {
                $table->enum('jenis', ['Musdus', 'Musrenbang', 'BPD'])->after('id_tahun')->nullable();
            }
            if (!Schema::hasColumn('berita_acara', 'putusan')) {
                $table->text('putusan')->nullable()->after('materi');
            }
            // Modify existing columns if needed (using change() requires doctrine/dbal, so avoiding unless necessary)
            // Assuming 'materi' is string (255), we might want TEXT.
            // Since SQLite/some DBs have issues with change(), we often just drop/add or assume string is enough or manual SQL.
            // For now, let's create a new 'materi_text' if change is complex, OR try raw statement.
            // However, typical Laravel change:
            // $table->text('materi')->change(); 
            // We'll skip complex changes to avoid dependency issues for now, unless 'materi' needs to be TEXT. 
            // The prompt says 'materi' (text area) using TinyMCE, so it likely needs TEXT.
            // Let's try attempting change if user installed dbal, otherwise we might need a workaround.
            // Safest without DBAL: leave as is or drop/recreate column.
            // Let's assume for now 255 chars is too short. 
            // Workaround: Drop column and add as text.
        });

        // Use raw SQL to alter column type to TEXT to be safe without doctrine/dbal if it's MySQL
        // DB::statement('ALTER TABLE berita_acara MODIFY COLUMN materi TEXT NULL'); 
        // But let's try the Laravel way first, wrapping in try-catch or just adding 'putusan' first.
        
        // Actually, let's just make sure 'materi' is large enough.
        // If we can't change it easily, we might just add it. 
        // Let's assume we can use change() or drop and re-add.
        
        Schema::table('berita_acara', function (Blueprint $table) {
             $table->text('materi')->change();
        });

        Schema::create('peserta_berita_acara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_berita')->constrained('berita_acara', 'id_berita')->onDelete('cascade');
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('jabatan')->default('Peserta'); // e.g. Ketua, Sekretaris, Anggota
            $table->string('tanda_tangan')->nullable(); // Path to signature image if needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_berita_acara');

        Schema::table('berita_acara', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'putusan']);
            $table->string('materi')->change(); // Revert to string
        });
    }
};
