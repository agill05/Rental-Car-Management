<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisMobil extends Model
{
    protected $fillable = 
    [
        'nama_jenis'
    ];

    public function mobils()
    {
        return $this->hasMany(Mobil::class);
    }
}
