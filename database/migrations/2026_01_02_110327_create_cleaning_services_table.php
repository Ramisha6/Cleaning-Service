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
        Schema::create('cleaning_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_image');
            $table->string('service_title');
            $table->string('service_price');
            $table->string('service_short_description');
            $table->longText('service_long_description');
            $table->enum('service_status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleaning_services');
    }
};
