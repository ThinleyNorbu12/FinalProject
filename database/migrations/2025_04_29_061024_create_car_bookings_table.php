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
            $table->unsignedBigInteger('customer_id');
            $table->string('pickup_location', 255);
            $table->string('dropoff_location', 255);
            
            // Use datetime fields instead of separate date/time
            $table->datetime('pickup_datetime');
            $table->datetime('dropoff_datetime');
            
            $table->enum('status', ['pending', 'confirmed'])
                ->default('pending')
                ->index();
            $table->timestamps();
            
            // Foreign keys and indexes...
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