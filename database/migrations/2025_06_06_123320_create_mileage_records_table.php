<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMileageRecordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mileage_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->enum('record_type', ['pickup', 'return'])->default('pickup');
            
            // Pickup information
            $table->unsignedInteger('mileage_at_pickup')->nullable();
            $table->enum('fuel_level_pickup', ['Empty', '1/4', '1/2', '3/4', 'Full'])->nullable();
            $table->text('pickup_notes')->nullable();
            $table->text('car_condition_pickup')->nullable();
            $table->timestamp('recorded_at')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable();
            
            // Return information
            $table->unsignedInteger('mileage_at_return')->nullable();
            $table->enum('fuel_level_return', ['Empty', '1/4', '1/2', '3/4', 'Full'])->nullable();
            $table->text('return_notes')->nullable();
            $table->text('car_condition_return')->nullable();
            $table->enum('damage_reported', ['Yes', 'No'])->default('No');
            $table->text('damage_description')->nullable();
            $table->timestamp('return_recorded_at')->nullable();
            
            // Calculated fields
            $table->unsignedInteger('mileage_used')->nullable();
            $table->unsignedInteger('excess_mileage')->nullable();
            $table->decimal('excess_charges', 10, 2)->nullable();
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('booking_id')
                  ->references('id')
                  ->on('car_bookings')
                  ->onDelete('cascade');
                  
            // Indexes
            $table->index('booking_id');
            $table->index('record_type');
            $table->index('recorded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mileage_records');
    }
}