<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Rt extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            // Dusun 1 - RW 01
            ['id_rt' => '1', 'id_dusun' => '1', 'id_rw' => '1', 'nama_rt' => 'RT 01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '2', 'id_dusun' => '1', 'id_rw' => '1', 'nama_rt' => 'RT 02', 'created_at' => $now, 'updated_at' => $now],
            // Dusun 1 - RW 02
            ['id_rt' => '3', 'id_dusun' => '1', 'id_rw' => '2', 'nama_rt' => 'RT 01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '4', 'id_dusun' => '1', 'id_rw' => '2', 'nama_rt' => 'RT 02', 'created_at' => $now, 'updated_at' => $now],
            
            // Dusun 2 - RW 03
            ['id_rt' => '5', 'id_dusun' => '2', 'id_rw' => '3', 'nama_rt' => 'RT 01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '6', 'id_dusun' => '2', 'id_rw' => '3', 'nama_rt' => 'RT 02', 'created_at' => $now, 'updated_at' => $now],
            // Dusun 2 - RW 04
            ['id_rt' => '7', 'id_dusun' => '2', 'id_rw' => '4', 'nama_rt' => 'RT 01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '8', 'id_dusun' => '2', 'id_rw' => '4', 'nama_rt' => 'RT 02', 'created_at' => $now, 'updated_at' => $now],

            // Dusun 3 - RW 05
            ['id_rt' => '9', 'id_dusun' => '3', 'id_rw' => '5', 'nama_rt' => 'RT 01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '10', 'id_dusun' => '3', 'id_rw' => '5', 'nama_rt' => 'RT 02', 'created_at' => $now, 'updated_at' => $now],
            // Dusun 3 - RW 06
            ['id_rt' => '11', 'id_dusun' => '3', 'id_rw' => '6', 'nama_rt' => 'RT 01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '12', 'id_dusun' => '3', 'id_rw' => '6', 'nama_rt' => 'RT 02', 'created_at' => $now, 'updated_at' => $now],

            // Dusun 4 - RW 07
            ['id_rt' => '13', 'id_dusun' => '4', 'id_rw' => '7', 'nama_rt' => 'RT 01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '14', 'id_dusun' => '4', 'id_rw' => '7', 'nama_rt' => 'RT 02', 'created_at' => $now, 'updated_at' => $now],
            // Dusun 4 - RW 08
            ['id_rt' => '15', 'id_dusun' => '4', 'id_rw' => '8', 'nama_rt' => 'RT 01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '16', 'id_dusun' => '4', 'id_rw' => '8', 'nama_rt' => 'RT 02', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($rows as $r) {
            DB::table('rt')->updateOrInsert(['id_rt' => $r['id_rt']], $r);
        }
    }
}
