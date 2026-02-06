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
            ['id_rw' => '1', 'id_dusun' => '1', 'nama_rw' => 'RW01', 'created_at' => $now, 'updated_at' => $now],
            ['id_rw' => '2', 'id_dusun' => '2', 'nama_rw' => 'RW02', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($rows as $r) {
            DB::table('rw')->updateOrInsert(['id_rw' => $r['id_rw']], $r);
        }
    }
}
