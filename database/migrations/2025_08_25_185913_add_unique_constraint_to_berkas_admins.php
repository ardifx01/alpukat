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
        Schema::table('berkas_admins', function (Blueprint $table) {
            // Menambahkan unique index pada kombinasi verifikasi_id dan jenis_surat
            $table->unique(['verifikasi_id', 'jenis_surat'], 'berkas_verif_jenis_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas_admins', function (Blueprint $table) {
            // Menghapus unique index saat rollback
            $table->dropUnique('berkas_verif_jenis_unique');
        });
    }
};
