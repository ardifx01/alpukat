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
        Schema::dropIfExists('pengajuan');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // kalau ada struktur lain sebelumnya, bisa kamu isi juga
        });
    }
};
