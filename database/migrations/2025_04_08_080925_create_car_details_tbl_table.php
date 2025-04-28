<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     public function up(): void
//     {
//         // Create car_details_tbl to store car details
//         Schema::create('car_details_tbl', function (Blueprint $table) {
//             $table->id();
//             $table->string('maker');
//             $table->string('model');
//             $table->string('vehicle_type');
//             $table->string('car_condition');
//             $table->integer('mileage');
//             $table->decimal('price', 10, 2);
//             $table->string('registration_no');
//             $table->string('status')->default('pending');
//             $table->text('description');
//             $table->string('car_image')->nullable();
//             $table->unsignedBigInteger('car_owner_id'); // This links the car to the owner
//             $table->foreign('car_owner_id')->references('id')->on('car_owners')->onDelete('cascade'); // FK reference to car_owners table
//             $table->timestamps();
//         });
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('car_details_tbl');
//     }
// };

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
            // New fields added
            $table->integer('number_of_doors'); // Number of doors
            $table->integer('number_of_seats'); // Number of seats
            $table->string('transmission_type'); // Transmission type
            $table->integer('large_bags_capacity'); // Capacity for large bags
            $table->integer('small_bags_capacity'); // Capacity for small bags
            $table->string('fuel_type'); // Fuel type
            $table->string('air_conditioning')->default('No');
            $table->string('backup_camera')->default('No');
            $table->string('bluetooth')->default('No');
            // Whether the car has Bluetooth
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Drop the car_details_tbl if the migration is rolled back
        Schema::dropIfExists('car_details_tbl');
    }
};
