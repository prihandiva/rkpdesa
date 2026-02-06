<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usulan;
use App\Models\Dusun;
use App\Models\RW;
use App\Models\RT;

class UsulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dusuns = Dusun::all();

        if ($dusuns->isEmpty()) {
            return;
        }

        foreach ($dusuns as $dusun) {
            // Get RWs for this Dusun
            $rws = RW::where('id_dusun', $dusun->id_dusun)->get();

            if ($rws->isEmpty()) {
                continue;
            }

            foreach ($rws as $rw) {
                // Get RTs for this RW
                $rts = RT::where('id_rw', $rw->id_rw)->get();

                if ($rts->isEmpty()) {
                    continue;
                }

                foreach ($rts as $rt) {
                    // Create some usulan for this RT
                    Usulan::create([
                        'jenis_kegiatan' => 'Pembangunan Jalan Paving ' . $rt->nama_rt,
                        'id_dusun' => $dusun->id_dusun,
                        'id_rw' => $rw->id_rw,
                        'id_rt' => $rt->id_rt,
                        'prioritas' => rand(1, 5),
                        'status' => 'Pending',
                        'tahun' => date('Y'),
                    ]);

                    Usulan::create([
                        'jenis_kegiatan' => 'Renovasi Pos Kamling ' . $rt->nama_rt,
                        'id_dusun' => $dusun->id_dusun,
                        'id_rw' => $rw->id_rw,
                        'id_rt' => $rt->id_rt,
                        'prioritas' => rand(1, 5),
                        'status' => 'Approved',
                        'tahun' => date('Y'),
                    ]);
                }
            }
        }
    }
}
