<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel lain
            $table->foreignId('mobil_id')->constrained('mobils');
            $table->foreignId('pelanggan_id')->constrained('pelanggans');
            $table->foreignId('supir_id')->nullable()->constrained('supirs');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali_rencana');
            
            $table->integer('lama_sewa');
            $table->decimal('harga_total', 12, 2);
            
            // PENTING: Status harus mencakup 'menunggu_persetujuan'
            $table->enum('status', ['dipinjam', 'menunggu_persetujuan', 'dikembalikan'])->default('dipinjam');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};