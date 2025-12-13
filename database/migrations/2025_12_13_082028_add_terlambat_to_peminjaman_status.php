<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('dipinjam', 'menunggu_persetujuan', 'menunggu_pengembalian', 'terlambat', 'dikembalikan') DEFAULT 'dipinjam'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('dipinjam', 'menunggu_persetujuan', 'menunggu_pengembalian', 'dikembalikan') DEFAULT 'dipinjam'");
    }
};
