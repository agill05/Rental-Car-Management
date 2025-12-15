<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'mobil_id',
        'pelanggan_id',
        'supir_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'lama_sewa',
        'harga_total',
        'status'
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

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    public function isOverdue()
    {
        return now()->gt(\Carbon\Carbon::parse($this->tanggal_kembali_rencana));
    }

    public function calculateFine()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $overdueDays = \Carbon\Carbon::parse($this->tanggal_kembali_rencana)->diffInDays(now());
        return $overdueDays * 50000;
    }
}
