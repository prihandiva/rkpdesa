<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dusun extends Model
{
    use SoftDeletes;

    protected $table = 'dusun';
    protected $primaryKey = 'id_dusun';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
    ];

    /**
     * Get the usulans for the dusun.
     */
    public function usulan()
    {
        return $this->hasMany(Usulan::class, 'id_dusun', 'id_dusun');
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
