<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('verifikasis', function (Blueprint $table) {
            // Hapus foreign key constraint dulu
            $table->dropForeign(['user_id']);
            // Baru hapus kolomnya
            $table->dropColumn('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('verifikasis', function (Blueprint $table) {
            // Tambahkan kolom dan foreign key kembali (optional)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
