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
        Schema::dropIfExists('job_batches');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('job_batches', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->int('total_jobs');

            $table->int('pending_jobs');

            $table->int('failed_jobs');

            $table->int('failed_job_ids');

            $table->mediumText('options');

            $table->int('cancelled_at');

            $table->int('created_at');

            $table->int('finished_at');
        });
    }
};
