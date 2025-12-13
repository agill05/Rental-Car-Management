<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $fillable = [
        'merek_id',
        'jenis_mobil_id',
        'nama_mobil',
        'no_polisi',
        'harga_per_hari',
        'status',
        'gambar', // Field baru
        'tahun'
    ];

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }
    public function jenisMobil()
    {
        return $this->belongsTo(JenisMobil::class);
    }
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}