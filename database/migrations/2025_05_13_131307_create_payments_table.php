<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('booking_id')
                  ->constrained('car_bookings')
                  ->onDelete('cascade')
                  ->index();
                  
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade')
                  ->index();

            // Payment details
            $table->enum('payment_method', [
                'qr_code', 
                'bank_transfer', 
                'pay_later',
                'card' // Added for future payment methods
            ])->index();
            
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('BTN'); // ISO currency code
            $table->enum('status', [
                'pending',
                'pending_verification', // Added missing status
                'processing',
                'completed',
                'failed',
                'refunded',
                'cancelled'
            ])->default('pending')->index();
            
            $table->string('reference_number', 100)->unique(); // Changed to unique
            $table->timestamp('payment_date')->useCurrent(); // Non-nullable
            
            $table->timestamps();

            // Additional indexes
            $table->index('reference_number');
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};