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
        Schema::create('cleaner_assigns', function (Blueprint $table) {
            $table->id();
            $table->integer('cleaner_id');
            $table->integer('job_id');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleaner_assigns');
    }
};
