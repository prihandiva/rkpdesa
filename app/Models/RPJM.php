<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RPJM extends Model
{
    use SoftDeletes;

    protected $table = 'rpjm';
    protected $primaryKey = 'id_rpjm';
    
    protected $fillable = [
        'status',
        'periode',
        'prioritas',
        'bidang',
        'subbidang',
        'jenis_kegiatan',
        'jenis',
        'lokasi',
        'volume',
        'sasaran',
        'waktu',
        'jumlah',
        'tahun_pelaksanaan',
        'sumber_biaya',
        'pola_pelaksanaan',
        'catatan_verifikasi',
    ];

    public function masterBidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang', 'id_bidang');
    }


    public function masterPola()
    {
        return $this->belongsTo(PolaPelaksanaan::class, 'pola_pelaksanaan', 'id_pelaksanaan');
    }

    public function getSumberBiayaModelsAttribute()
    {
        if (empty($this->sumber_biaya)) {
            return collect();
        }
        $ids = is_array($this->sumber_biaya) ? $this->sumber_biaya : [$this->sumber_biaya];
        return \App\Models\SumberBiaya::whereIn('id_biaya', $ids)->get();
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
            'sumber_biaya' => 'array',
        ];
    }
}
