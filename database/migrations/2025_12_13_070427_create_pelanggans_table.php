<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            
            // PENTING: Relasi ke tabel users
            // Jika user dihapus, data pelanggan ikut terhapus (cascade)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('no_hp');
            $table->text('alamat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};