<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_cars_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('maker');
            $table->string('model');
            $table->string('vehicle_type');
            $table->string('car_condition');
            $table->integer('mileage');
            $table->decimal('price', 10, 2);
            $table->string('registration_no')->unique();
            $table->string('status')->default('available');
            $table->text('description')->nullable();
            $table->string('car_image')->nullable();

            // If you want to track which admin added the car
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');

            // Additional car features
            $table->integer('number_of_doors');
            $table->integer('number_of_seats');
            $table->string('transmission_type');
            $table->integer('large_bags_capacity')->default(0);
            $table->integer('small_bags_capacity')->default(0);
            $table->string('fuel_type');
            $table->string('air_conditioning')->default('No');
            $table->string('backup_camera')->default('No');
            $table->string('bluetooth')->default('No');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_cars_tbl');
    }
};
