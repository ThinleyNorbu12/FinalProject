<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up(): void
//     {
//         Schema::create('pay_later_payments', function (Blueprint $table) {
//             $table->id();

//             // Reference to the booking where this payment applies
//             $table->foreignId('booking_id')
//                 ->constrained('car_bookings')
//                 ->onDelete('cascade');

//             // Optional transaction/payment ID (if stored separately)
//             $table->foreignId('payment_id')
//                 ->nullable()
//                 ->constrained('payments')
//                 ->onDelete('cascade');

//             // Payment status   
//             $table->enum('status', ['upcoming', 'pending', 'paid', 'overdue', 'cancelled'])
//                 ->default('pending');



//             // When the payment was collected
//             $table->timestamp('collection_date')->nullable();

//             // Admin who collected it (plain string for name or username)
//             $table->string('collected_by_admin')->nullable();

//             // Payment method used during handover
//             $table->enum('collection_method', ['cash', 'card', 'bank_transfer', 'qr_code'])
//                 ->nullable();

//             // Any notes about the payment
//             $table->text('notes')->nullable();

//             $table->timestamps();

//             // Optional indexes
//             $table->index('status');
//             $table->index('collection_date');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('pay_later_payments');
//     }
// };


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pay_later_payments', function (Blueprint $table) {
            $table->id();

            // Reference to the booking where this payment applies
            $table->foreignId('booking_id')
                ->constrained('car_bookings')
                ->onDelete('cascade');

            // Optional transaction/payment ID (if stored separately)
            $table->foreignId('payment_id')
                ->nullable()
                ->constrained('payments')
                ->onDelete('cascade');

            // Payment status   
            $table->enum('status', ['upcoming', 'pending', 'paid', 'overdue', 'cancelled'])
                ->default('pending');

            // When the payment was collected
            $table->timestamp('collection_date')->nullable();

            // Admin who collected it (plain string for name or username)
            $table->string('collected_by_admin')->nullable();

            // Payment method used during handover
            $table->enum('collection_method', ['cash', 'card', 'bank_transfer', 'qr_code'])
                ->nullable();

            // Any notes about the payment
            $table->text('notes')->nullable();

            // ✅ Screenshot image path (e.g., receipts or confirmations)
            $table->string('screenshot_image_path')->nullable();

            $table->timestamps();

            // Optional indexes
            $table->index('status');
            $table->index('collection_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_later_payments');
    }
};
