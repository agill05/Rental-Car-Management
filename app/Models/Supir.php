<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supir extends Model
{
    protected $fillable = [
        'nama',
        'nik',
        'no_hp',
        'alamat',
        'tarif_per_hari',
        'status',
        'foto' // Field baru
    ];
}