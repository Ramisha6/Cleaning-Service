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
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dateTime('booking_start_at')->nullable()->after('booking_date');
            $table->dateTime('booking_end_at')->nullable()->after('booking_start_at');

            $table->index(['booking_start_at', 'booking_end_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropIndex(['booking_start_at', 'booking_end_at']);
            $table->dropColumn(['booking_start_at', 'booking_end_at']);
        });
    }
};
