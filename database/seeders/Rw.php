<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Rw extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            // Dusun 1 (Krajan)
            ['id_rw' => '1', 'id_dusun' => '1', 'nama_rw' => 'RW 01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rw' => '2', 'id_dusun' => '1', 'nama_rw' => 'RW 02', 'created_at' => $now, 'updated_at' => $now],
            // Dusun 2 (Santren)
            ['id_rw' => '3', 'id_dusun' => '2', 'nama_rw' => 'RW 03', 'created_at' => $now, 'updated_at' => $now],
            ['id_rw' => '4', 'id_dusun' => '2', 'nama_rw' => 'RW 04', 'created_at' => $now, 'updated_at' => $now],
            // Dusun 3 (Pandan Selatan)
            ['id_rw' => '5', 'id_dusun' => '3', 'nama_rw' => 'RW 05', 'created_at' => $now, 'updated_at' => $now],
            ['id_rw' => '6', 'id_dusun' => '3', 'nama_rw' => 'RW 06', 'created_at' => $now, 'updated_at' => $now],
            // Dusun 4 (Sigromilir)
            ['id_rw' => '7', 'id_dusun' => '4', 'nama_rw' => 'RW 07', 'created_at' => $now, 'updated_at' => $now],
            ['id_rw' => '8', 'id_dusun' => '4', 'nama_rw' => 'RW 08', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($rows as $r) {
            DB::table('rw')->updateOrInsert(['id_rw' => $r['id_rw']], $r);
        }
    }
}
