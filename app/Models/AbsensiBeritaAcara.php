<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiBeritaAcara extends Model
{
    protected $table = 'absensi_berita_acara';

    protected $fillable = [
        'id_berita',
        'nama',
        'alamat',
        'unsur',
    ];

    /**
     * Relationship to Berita Acara
     */
    public function beritaAcara()
    {
        return $this->belongsTo(BeritaAcara::class, 'id_berita', 'id_berita');
    }
}
