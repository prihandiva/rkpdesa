<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaBeritaAcara extends Model
{
    protected $table = 'peserta_berita_acara';

    protected $fillable = [
        'id_berita',
        'nama',
        'alamat',
        'jabatan',
        'tanda_tangan',
    ];

    public function beritaAcara()
    {
        return $this->belongsTo(BeritaAcara::class, 'id_berita', 'id_berita');
    }
}
