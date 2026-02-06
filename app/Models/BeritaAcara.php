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
        'hari',
        'tanggal',
        'tempat',
        'materi',
        'pemimpin',
        'notulis1',
        'notulis2',
    ];

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
