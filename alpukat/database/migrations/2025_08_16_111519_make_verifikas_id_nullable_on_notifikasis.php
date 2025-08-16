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
        Schema::table('notifikasis', function (Blueprint $table) {
            // lepas FK lama (abaikan error kalau namanya beda)
            try { $table->dropForeign(['verifikasi_id']); } catch (\Throwable $e) {}

            // jadikan nullable
            $table->unsignedBigInteger('verifikasi_id')->nullable()->change();

            // pasang FK lagi; kalau verifikasinya dihapus → set null
            $table->foreign('verifikasi_id')
                  ->references('id')->on('verifikasis')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasis', function (Blueprint $table) {
            try { $table->dropForeign(['verifikasi_id']); } catch (\Throwable $e) {}
            $table->unsignedBigInteger('verifikasi_id')->nullable(false)->change();
            $table->foreign('verifikasi_id')
                  ->references('id')->on('verifikasis')
                  ->cascadeOnDelete();
        });
    }
};
