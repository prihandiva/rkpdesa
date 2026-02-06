<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RW extends Model
{
    use SoftDeletes;

    protected $table = 'rw';
    protected $primaryKey = 'id_rw';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_dusun',
        'nama_rw',
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
    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'id_dusun', 'id_dusun');
    }
}
