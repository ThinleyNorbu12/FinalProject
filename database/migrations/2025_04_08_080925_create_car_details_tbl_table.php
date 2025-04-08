<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create car_details_tbl to store car details
        Schema::create('car_details_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('maker');
            $table->string('model');
            $table->string('vehicle_type');
            $table->string('car_condition');
            $table->integer('mileage');
            $table->decimal('price', 10, 2);
            $table->string('registration_no');
            $table->string('status')->default('pending');
            $table->text('description');
            $table->string('car_image')->nullable();
            $table->unsignedBigInteger('car_owner_id'); // This links the car to the owner
            $table->foreign('car_owner_id')->references('id')->on('car_owners')->onDelete('cascade'); // FK reference to car_owners table
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_details_tbl');
    }
};
