<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usulan extends Model
{
    use SoftDeletes;

    protected $table = 'usulan';
    protected $primaryKey = 'id_usulan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jenis_kegiatan',
        'id_dusun',
        'id_rw',
        'id_rt',
        'prioritas',
        'status',
        'tahun',
        'file_berita_acara',
    ];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'id_dusun', 'id_dusun');
    }

    public function rw()
    {
        return $this->belongsTo(RW::class, 'id_rw', 'id_rw');
    }

    public function rt()
    {
        return $this->belongsTo(RT::class, 'id_rt', 'id_rt');
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
