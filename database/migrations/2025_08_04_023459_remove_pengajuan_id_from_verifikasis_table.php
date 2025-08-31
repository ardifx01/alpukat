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
            $table->dropForeign(['pengajuan_id']);
            $table->dropColumn(('pengajuan_id'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verifikasis', function (Blueprint $table) {
            $table->unsignedBigInteger('pengajuan_id')->nullable();
            $table->foreign('pengajuan_id')->references('id')->on('pengajuan')->onDelete('cascade');
        });
    }
};
