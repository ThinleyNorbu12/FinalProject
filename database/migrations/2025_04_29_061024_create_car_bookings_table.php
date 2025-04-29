<?php

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
            $table->string('pickup_location');
            $table->date('pickup_date');
            $table->string('dropoff_location');
            $table->date('dropoff_date');
            $table->timestamps();

            // Foreign key to link car_id to car_details_tbl(id)
            $table->foreign('car_id')
                  ->references('id')
                  ->on('car_details_tbl')
                  ->onDelete('cascade');
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
