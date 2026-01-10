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
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();
            
            $table->string('invoice_no', 50)->unique(); // INV-YYYYMMDD-000001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('cleaning_services')->cascadeOnDelete();

            // Booking info
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->string('phone', 30);
            $table->date('booking_date');
            $table->text('note')->nullable();

            // Payment
            $table->enum('payment_method', ['cod', 'bkash'])->default('cod');
            $table->string('bkash_number', 20)->nullable();
            $table->string('transaction_id', 80)->nullable();
            $table->enum('payment_status', ['pending', 'unverified', 'verified', 'rejected'])->default('pending');

            // Booking status
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

            //progress status
            $table->enum('progress_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');

            $table->timestamps();

            $table->index(['service_id', 'booking_date']);
            $table->index('user_id');
            $table->index(['payment_method', 'payment_status']);

            // Allow same trx id only once when present
            $table->unique('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_bookings');
    }
};
