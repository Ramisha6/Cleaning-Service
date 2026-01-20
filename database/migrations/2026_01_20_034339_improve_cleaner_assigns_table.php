<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cleaner_assigns', function (Blueprint $table) {
            // If your columns are int, keep them but add indexes/unique.
            $table->index('cleaner_id');
            $table->index('job_id');

            // One cleaner per booking (recommended)
            $table->unique('job_id');

            // Or if you want multiple cleaners per job, use:
            // $table->unique(['cleaner_id','job_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cleaner_assigns', function (Blueprint $table) {
            $table->dropUnique(['job_id']);
            $table->dropIndex(['cleaner_id']);
            $table->dropIndex(['job_id']);
        });
    }
};
