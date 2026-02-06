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
            // RTs for RW 1 (dusun-krajan)
            ['id_rt' => '1', 'id_dusun' => '1', 'id_rw' => '1', 'nama_rt' => 'RT01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '2', 'id_dusun' => '1', 'id_rw' => '1', 'nama_rt' => 'RT02', 'created_at' => $now, 'updated_at' => $now],
            // RTs for RW 2 (dusun-santren)
            ['id_rt' => '3', 'id_dusun' => '2', 'id_rw' => '2', 'nama_rt' => 'RT01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rt' => '4', 'id_dusun' => '2', 'id_rw' => '2', 'nama_rt' => 'RT02', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($rows as $r) {
            DB::table('rt')->updateOrInsert(['id_rt' => $r['id_rt']], $r);
        }
    }
}
