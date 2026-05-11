<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $users = [
            // id_user as numeric string
            ['id_user' => '1', 'nama' => 'Admin Sistem', 'role' => 'admin', 'username' => 'admin', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'admin@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '2', 'nama' => 'Operator Desa', 'role' => 'operator_desa', 'username' => 'opdesa', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'opdesa@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '3', 'nama' => 'Tim Verifikasi', 'role' => 'tim_verifikasi', 'username' => 'timverif', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'timverif@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '4', 'nama' => 'Tim Penyusun RKPDesa', 'role' => 'tim_penyusun', 'username' => 'penyusunrkp', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'penyusunrkp@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '5', 'nama' => 'Budi Kurniawan', 'role' => 'bpd', 'username' => 'bpd', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'bpd@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            
            // Dusun Accounts
            ['id_user' => '6', 'nama' => 'Kasun Krajan', 'role' => 'operator_dusun', 'username' => 'krajan', 'telp' => null, 'id_dusun' => '1', 'id_rw' => null, 'id_rt' => null, 'email' => 'krajan@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '7', 'nama' => 'Kasun Santren', 'role' => 'operator_dusun', 'username' => 'santren', 'telp' => null, 'id_dusun' => '2', 'id_rw' => null, 'id_rt' => null, 'email' => 'santren@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '8', 'nama' => 'Kasun Pandan Selatan', 'role' => 'operator_dusun', 'username' => 'pandanselatan', 'telp' => null, 'id_dusun' => '3', 'id_rw' => null, 'id_rt' => null, 'email' => 'pandanselatan@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '9', 'nama' => 'Kasun Sigromilir', 'role' => 'operator_dusun', 'username' => 'sigromilir', 'telp' => null, 'id_dusun' => '4', 'id_rw' => null, 'id_rt' => null, 'email' => 'sigromilir@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($users as $u) {
            DB::table('users')->updateOrInsert(['id_user' => $u['id_user']], $u);
        }
    }
}
