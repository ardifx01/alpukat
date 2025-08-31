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
        Schema::dropIfExists('jobs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            $table->string('queue')->unique();

            $table->longtext('payload');

            $table->tinyint('attempts');

            $table->int('reserved_at');

            $table->int('available_at');

            $table->int('created_at');
        });
    }
};
