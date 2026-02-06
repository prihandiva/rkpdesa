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
            ['id_user' => '1', 'nama' => 'Admin Sistem', 'role' => 'admin', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'admin@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '2', 'nama' => 'OP Dusun', 'role' => 'operator_dusun', 'telp' => null, 'id_dusun' => '1', 'id_rw' => '1', 'id_rt' => '1', 'email' => 'opdusun@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '3', 'nama' => 'OP Desa', 'role' => 'operator_desa', 'telp' => null, 'id_dusun' => '2', 'id_rw' => '2', 'id_rt' => '2', 'email' => 'opdesa@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '4', 'nama' => 'Tim Verif', 'role' => 'tim_verifikasi', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'timverif@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '5', 'nama' => 'Penyusun RKP', 'role' => 'tim_penyusun', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'penyusunrkp@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '6', 'nama' => 'BPD', 'role' => 'bpd', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'bpd@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => '7', 'nama' => 'Bendahara', 'role' => 'bendahara', 'telp' => null, 'id_dusun' => null, 'id_rw' => null, 'id_rt' => null, 'email' => 'bendahara@example.test', 'password' => Hash::make('password'), 'profile_image' => null, 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($users as $u) {
            DB::table('users')->updateOrInsert(['id_user' => $u['id_user']], $u);
        }
    }
}
