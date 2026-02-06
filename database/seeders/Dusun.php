<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dusun extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $dusuns = [
            ['id_dusun' => '1', 'nama' => 'Dusun Krajan', 'created_at' => $now, 'updated_at' => $now],
            ['id_dusun' => '2', 'nama' => 'Dusun Santren', 'created_at' => $now, 'updated_at' => $now],
            ['id_dusun' => '3', 'nama' => 'Dusun Pandan Selatan', 'created_at' => $now, 'updated_at' => $now],
            ['id_dusun' => '4', 'nama' => 'Dusun Sigromilir', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($dusuns as $d) {
            DB::table('dusun')->updateOrInsert(['id_dusun' => $d['id_dusun']], $d);
        }
    }
}
