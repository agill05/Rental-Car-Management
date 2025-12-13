<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menambahkan kolom 'gambar' ke tabel mobils
        Schema::table('mobils', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('status');
        });

        // Menambahkan kolom 'foto' ke tabel supirs
        Schema::table('supirs', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom jika rollback
        Schema::table('mobils', function (Blueprint $table) {
            $table->dropColumn('gambar');
        });

        Schema::table('supirs', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};