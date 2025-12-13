<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            // Relasi One-to-One ke Peminjaman
            $table->foreignId('peminjaman_id')->constrained('peminjaman');

            $table->date('tanggal_kembali_aktual');
            $table->decimal('denda', 12, 2)->default(0); // Jika terlambat
            $table->decimal('total_bayar_akhir', 12, 2); // Biaya awal + Denda
            $table->text('catatan_kondisi')->nullable(); // Misal: baret, bensin kosong
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
