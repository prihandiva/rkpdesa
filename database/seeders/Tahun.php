<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Tahun extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = [
            [
                'tahun' => '2025',
                'status' => 'Nonaktif',
            ],
            [
                'tahun' => '2026',
                'status' => 'Aktif', // 2026 Aktif
            ],
            [
                'tahun' => '2027',
                'status' => 'Nonaktif',
            ],
        ];

        foreach ($years as $year) {
            \App\Models\Tahun::updateOrCreate(
                ['tahun' => $year['tahun']],
                ['status' => $year['status']]
            );
        }
    }
}
