<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman'; // Pastikan nama tabel benar (singular)

    protected $fillable = [
        'mobil_id',
        'pelanggan_id',
        'supir_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'lama_sewa',    // Kolom baru
        'harga_total',  // Kolom baru
        'status'        // Enum: dipinjam, menunggu_persetujuan, dikembalikan
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function supir()
    {
        return $this->belongsTo(Supir::class);
    }

    // Relasi ke Pengembalian (One to One)
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}