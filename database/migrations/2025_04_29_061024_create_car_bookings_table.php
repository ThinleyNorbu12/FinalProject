<?php
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateCarBookingsTable extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('car_bookings', function (Blueprint $table) {
//             $table->id();
//             $table->unsignedBigInteger('car_id');
//             $table->unsignedBigInteger('customer_id');
//             $table->string('pickup_location', 255);
//             $table->string('dropoff_location', 255);
            
//             // Use datetime fields instead of separate date/time
//             $table->datetime('pickup_datetime');
//             $table->datetime('dropoff_datetime');
            
//             $table->enum('status', ['pending', 'confirmed'])
//                 ->default('pending')
//                 ->index();
//             $table->timestamps();
            
//             // Foreign keys and indexes...
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('car_bookings');
//     }
// }


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('customer_id');
            
            // Location fields
            $table->string('pickup_location', 255);
            $table->string('dropoff_location', 255);
            
            // Date/time fields
            $table->datetime('pickup_datetime');
            $table->datetime('dropoff_datetime');
            
            // Status with complete options
            $table->enum('status', [
                'pending',           // Initial booking state
                'confirmed',         // Booking confirmed
                'pending_verification', // Payment verification needed
                'cancelled',         // Booking cancelled
                'completed'          // Booking successfully completed
            ])->default('pending')->index();
            
            // Payment information
            $table->string('payment_method', 20)->nullable();
            $table->string('transaction_id', 100)->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('car_id')
                  ->references('id')
                  ->on('cars')
                  ->onDelete('cascade');
                  
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
            
            // Indexes for frequently searched fields
            $table->index('pickup_datetime');
            $table->index('dropoff_datetime');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_bookings');
    }
}