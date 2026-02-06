<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SumberBiaya extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $items = [
            ['kode' => 'ADD', 'nama' => 'Alokasi Dana Desa (ADD)', 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'DDS', 'nama' => 'Dana Desa (DDS/DD)', 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'PBH', 'nama' => 'Pendapatan Bagi Hasil (PBH)', 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'PAD', 'nama' => 'Pendapatan Asli Daerah (PAD)', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($items as $it) {
            DB::table('sumber_biaya')->updateOrInsert(['kode' => $it['kode']], $it);
        }
    }
}
