<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Pegawai extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $items = [
            ['id_pegawai' => '1', 'nama' => 'Hari Sulistiono', 'posisi' => 'Kepala Desa', 'NIP' => '197501012000011001', 'telp' => '081234567890', 'alamat' => 'Pandanlandung', 'email' => 'hari.sulistiono@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '2', 'nama' => 'A. Bagus Sadewa', 'posisi' => 'Sekretaris Desa', 'NIP' => '198002022005021002', 'telp' => '081234567891', 'alamat' => 'Pandanlandung', 'email' => 'bagus.sadewa@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '3', 'nama' => 'Cahya Dwi A.', 'posisi' => 'Kasi Pemerintahan', 'NIP' => '198503032010031003', 'telp' => '081234567892', 'alamat' => 'Pandanlandung', 'email' => 'cahya.dwi@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '4', 'nama' => 'Rino Ekananda', 'posisi' => 'Kasi Kesejahteraan Sosial', 'NIP' => '199004042015041004', 'telp' => '081234567893', 'alamat' => 'Pandanlandung', 'email' => 'rino.ekananda@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '5', 'nama' => 'Moh Ikhsan', 'posisi' => 'Kasi Pelayanan', 'NIP' => '199205052018051005', 'telp' => '081234567894', 'alamat' => 'Pandanlandung', 'email' => 'moh.ikhsan@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '6', 'nama' => 'Yesi Nilamsari', 'posisi' => 'Kaur Keuangan', 'NIP' => '199506062020062006', 'telp' => '081234567895', 'alamat' => 'Pandanlandung', 'email' => 'yesi.nilamsari@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '7', 'nama' => 'Untung Wijoyo', 'posisi' => 'Kaur Perencanaan', 'NIP' => '198807072012071007', 'telp' => '081234567896', 'alamat' => 'Pandanlandung', 'email' => 'untung.wijoyo@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '8', 'nama' => 'Novia Rahayu', 'posisi' => 'Kaur Tata Usaha/Umum', 'NIP' => '199708082022082008', 'telp' => '081234567897', 'alamat' => 'Pandanlandung', 'email' => 'novia.rahayu@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '9', 'nama' => 'Hendri Kustomo', 'posisi' => 'Kasun Krajan', 'NIP' => '198209092008091009', 'telp' => '081234567898', 'alamat' => 'Krajan', 'email' => 'hendri.kustomo@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '10', 'nama' => 'Supardi', 'posisi' => 'Kasun Pandan Selatan', 'NIP' => '197810102002101010', 'telp' => '081234567899', 'alamat' => 'Pandan Selatan', 'email' => 'supardi@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '11', 'nama' => 'Rifqi Putra M.', 'posisi' => 'Kasun Sigromilir', 'NIP' => '199411112019111011', 'telp' => '081234567800', 'alamat' => 'Sigromilir', 'email' => 'rifqi.putra@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => '12', 'nama' => 'Tegar Rinus S.', 'posisi' => 'Kasun Santren', 'NIP' => '199612122021121012', 'telp' => '081234567801', 'alamat' => 'Santren', 'email' => 'tegar.rinus@example.test', 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($items as $it) {
            DB::table('pegawai')->updateOrInsert(['id_pegawai' => $it['id_pegawai']], $it);
        }
    }
}
