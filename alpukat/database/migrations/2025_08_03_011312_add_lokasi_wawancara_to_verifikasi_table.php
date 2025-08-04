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
            $table->string('lokasi_wawancara')->nullable()->after('tanggal_wawancara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verifikasis', function (Blueprint $table) {
            $table->dropColumn('lokasi_wawancara');
        });
    }
};
