<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    protected $fillable =
    [
        'peminjaman_id',
        'tanggal_kembali_aktual',
        'denda',
        'total_bayar_akhir',
        'catatan_kondisi'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
