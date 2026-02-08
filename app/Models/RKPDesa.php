<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RKPDesa extends Model
{
    use SoftDeletes;

    protected $table = 'rkpdesa';
    protected $primaryKey = 'id_kegiatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'bidang',
        'jenis_kegiatan',
        'data_existing',
        'target_capaian',
        'lokasi',
        'volume',
        'penerima',
        'waktu',
        'jumlah',
        'sumber_biaya',
        'pola_pelaksanaan',
        'status',
        'tahun',
        'id_rpjm',
        'id_usulan',
        'catatan_verifikasi',
        'file_berita_acara_musrenbang',
        'prioritas',
    ];

    public function rpjm()
    {
        return $this->belongsTo(RPJM::class, 'id_rpjm', 'id_rpjm');
    }

    public function usulan()
    {
        return $this->belongsTo(Usulan::class, 'id_usulan', 'id_usulan');
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
