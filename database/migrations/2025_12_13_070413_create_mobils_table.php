<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            // Foreign Keys
            $table->foreignId('merek_id')->constrained('mereks');
            $table->foreignId('jenis_mobil_id')->constrained('jenis_mobils');
            $table->integer('tahun');
            $table->string('nama_mobil'); // Contoh: Avanza Veloz
            $table->string('no_polisi')->unique();
            $table->decimal('harga_per_hari', 10, 2);
            $table->enum('status', ['tersedia', 'disewa'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
