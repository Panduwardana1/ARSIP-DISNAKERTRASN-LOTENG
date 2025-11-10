<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
    ];

    public function rekomendasis()
    {
        return $this->hasMany(Rekomendasi::class);
    }
}
