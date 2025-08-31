<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('verifikasis', function (Blueprint $table) {
            // Tambahkan kolom user_id dulu jika belum ada
            if (!Schema::hasColumn('verifikasis', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id'); // atau posisikan sesuai kebutuhan
            }

            // Setelah itu baru tambah foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('verifikasis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id'); // optional, kalau kamu ingin rollback total
        });
    }
};
