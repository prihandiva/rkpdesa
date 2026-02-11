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
        'prioritas',
        'bidang',
        'subbidang',
        'jenis_kegiatan',
        'lokasi',
        'volume',
        'sasaran',
        'waktu',
        'jumlah',
        'jumlah',
        'sumber_biaya',
        'pola_pelaksanaan',
        'catatan_verifikasi',
    ];

    public function masterBidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang', 'id_bidang');
    }

    public function masterSumberBiaya()
    {
        return $this->belongsTo(SumberBiaya::class, 'sumber_biaya', 'id_biaya'); 
    }

    public function masterPola()
    {
        return $this->belongsTo(PolaPelaksanaan::class, 'pola_pelaksanaan', 'id_pelaksanaan');
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
