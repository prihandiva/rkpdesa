<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeritaAcara extends Model
{
    use SoftDeletes;

    protected $table = 'berita_acara';
    protected $primaryKey = 'id_berita';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_tahun',
        'id_dusun',
        'jenis',
        'hari',
        'tanggal',
        'tempat',
        'materi',
        'putusan',
        'pemimpin',
        'notulis1',
        'notulis2',
    ];

    /**
     * Relationship to Dusun
     */
    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'id_dusun', 'id_dusun');
    }

    /**
     * Relationship to Tahun
     */
    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_tahun', 'id_tahun');
    }

    /**
     * Relationship to Pegawai (Pemimpin)
     */
    public function pemimpinPegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pemimpin', 'id_pegawai');
    }

    /**
     * Relationship to Pegawai (Notulis 1)
     */
    public function notulis1Pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'notulis1', 'id_pegawai');
    }

    /**
     * Relationship to Pegawai (Notulis 2)
     */
    public function notulis2Pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'notulis2', 'id_pegawai');
    }

    /**
     * Relationship to Peserta
     */
    public function peserta()
    {
        return $this->hasMany(PesertaBeritaAcara::class, 'id_berita', 'id_berita');
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
