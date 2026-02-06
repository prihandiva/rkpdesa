<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $roles = [
            ['id_role' => '1', 'nama' => 'admin', 'created_at' => $now, 'updated_at' => $now],
            ['id_role' => '2', 'nama' => 'operator_dusun', 'created_at' => $now, 'updated_at' => $now],
            ['id_role' => '3', 'nama' => 'operator_desa', 'created_at' => $now, 'updated_at' => $now],
            ['id_role' => '4', 'nama' => 'tim_verifikasi', 'created_at' => $now, 'updated_at' => $now],
            ['id_role' => '5', 'nama' => 'tim_penyusun', 'created_at' => $now, 'updated_at' => $now],
            ['id_role' => '6', 'nama' => 'bpd', 'created_at' => $now, 'updated_at' => $now],
            ['id_role' => '7', 'nama' => 'bendahara', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Use upsert to avoid duplicate inserts when seeding multiple times
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(['id_role' => $role['id_role']], $role);
        }
    }
}
