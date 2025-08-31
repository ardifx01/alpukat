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
        Schema::table('verifikasis', function (Blueprint $table) {
            $table->dropColumn(['berita_acara', 'surat_ukk']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verifikasis', function (Blueprint $table) {
            $table->string('berita_acara')->nullable();
            $table->string('surat_ukk')->nullable();
        });
    }
};
