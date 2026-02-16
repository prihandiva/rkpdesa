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
        'bidang',
        'jenis_kegiatan',
        'jenis',
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
    /**
     * Check if the RKP Desa data is complete.
     *
     * @return bool
     */
    public function isComplete(): bool
    {
        // 1. Check for required fields (excluding IDs and file)
        $requiredAttributes = [
            'bidang',
            'jenis_kegiatan',
            'jenis',
            'data_existing',
            'target_capaian',
            'lokasi',
            'volume',
            'penerima',
            'waktu',
            'jumlah',
            'sumber_biaya',
            'pola_pelaksanaan',
            'tahun',
            'prioritas',
        ];

        foreach ($requiredAttributes as $attribute) {
            if (empty($this->$attribute)) {
                return false;
            }
        }

        // 2. Check Priorities
        if ($this->prioritas <= 0) {
            return false;
        }

        // 3. Check Source (Either Usulan or RPJM must be present)
        // User request: "jika id_rpjm atau id_usulan (cukup salah satu terisi)"
        // REVISION: User said "jika mereka kosong lewatkan saja". So we DO NOT check them.
        
        // 4. File Berita Acara is EXPLICITLY EXCLUDED from completeness check per user request.

        return true;
    }
}
