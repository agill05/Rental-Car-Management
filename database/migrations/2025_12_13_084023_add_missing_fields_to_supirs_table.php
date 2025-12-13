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
        Schema::table('supirs', function (Blueprint $table) {
            $table->string('nik')->unique()->after('nama');
            $table->text('alamat')->after('no_hp');
            $table->decimal('tarif_per_hari', 10, 2)->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supirs', function (Blueprint $table) {
            $table->dropColumn(['nik', 'alamat', 'tarif_per_hari']);
        });
    }
};
