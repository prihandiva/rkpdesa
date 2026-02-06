<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Bidang extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $rows = [
            ['id_bidang' => '1', 'nama' => 'BIDANG PENYELENGGARAAN PEMERINTAHAN DESA', 'created_at' => $now, 'updated_at' => $now],
            ['id_bidang' => '2', 'nama' => 'BIDANG PELAKSANAAN PEMBANGUNAN DESA', 'created_at' => $now, 'updated_at' => $now],
            ['id_bidang' => '3', 'nama' => 'BIDANG PEMBINAAN KEMASYARAKATAN', 'created_at' => $now, 'updated_at' => $now],
            ['id_bidang' => '4', 'nama' => 'BIDANG PEMBERDAYAAN MASYARAKAT', 'created_at' => $now, 'updated_at' => $now],
            ['id_bidang' => '5', 'nama' => 'PENANGGULANGAN BENCANA, KEADAAN MENDESAK DAN DARURAT LAINNYA', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($rows as $r) {
            DB::table('bidang')->updateOrInsert(['id_bidang' => $r['id_bidang']], $r);
        }
    }
}
