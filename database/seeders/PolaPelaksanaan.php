<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PolaPelaksanaan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $items = [
            ['id_pelaksanaan' => '1', 'nama' => 'Swakelola', 'created_at' => $now, 'updated_at' => $now],
            ['id_pelaksanaan' => '2', 'nama' => 'Kerjasama Antar Desa', 'created_at' => $now, 'updated_at' => $now],
            ['id_pelaksanaan' => '3', 'nama' => 'Kerjasama pihak ketiga', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($items as $it) {
            DB::table('pola_pelaksanaan')->updateOrInsert(['id_pelaksanaan' => $it['id_pelaksanaan']], $it);
        }
    }
}
