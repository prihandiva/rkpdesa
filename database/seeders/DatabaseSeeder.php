<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            Roles::class,
            Tahun::class,
            Bidang::class,
            SumberBiaya::class,
            PolaPelaksanaan::class,
            Dusun::class,
            Rw::class,
            Rt::class,
            Pegawai::class,
            Users::class,
        ]);
    }
}
