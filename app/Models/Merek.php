<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
    protected $fillable = 
    [
        'nama_merek'
    ];

    public function mobils()
    {
        return $this->hasMany(Mobil::class);
    }
}
