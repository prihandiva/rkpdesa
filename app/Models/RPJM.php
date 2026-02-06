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
        'visi',
        'misi',
        'tahun_mulai',
        'tahun_selesai',
        'file_dokumen',
    ];

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
