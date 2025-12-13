<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'user_id', // PENTING: Untuk menghubungkan dengan tabel users
        'nama',
        'nik',
        'no_hp',
        'alamat'
    ];

    // Relasi ke User (Akun Login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Peminjaman (History Transaksi)
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}