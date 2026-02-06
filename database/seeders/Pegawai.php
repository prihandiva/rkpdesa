<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Pegawai extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $items = [
            ['id_pegawai' => '1', 'nama' => 'Ahmad Santoso', 'posisi' => 'Kepala Desa', 'NIP' => null, 'telp' => null, 'alamat' => null, 'email' => 'ahmad.santoso@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '2', 'nama' => 'Siti Aminah', 'posisi' => 'Sekretaris', 'NIP' => null, 'telp' => null, 'alamat' => null, 'email' => 'siti.aminah@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '3', 'nama' => 'Budi Kurniawan', 'posisi' => 'Bendahara', 'NIP' => null, 'telp' => null, 'alamat' => null, 'email' => 'budi.kurniawan@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($items as $it) {
            DB::table('pegawai')->updateOrInsert(['id_pegawai' => $it['id_pegawai']], $it);
        }
    }
}
