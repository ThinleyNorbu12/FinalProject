<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarPricingTable extends Migration
{
    public function up(): void
    {
        Schema::create('car_pricing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->decimal('rate_per_day', 10, 2)->comment('Daily rental rate');
            $table->decimal('price_per_km', 8, 2)->comment('Price per km for exceeding mileage limit');
            $table->unsignedInteger('mileage_limit')->comment('Daily mileage limit in km');
            $table->unsignedInteger('current_mileage')->comment('Current vehicle mileage');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Foreign key
            $table->foreign('car_id')
                  ->references('id')
                  ->on('car_details_tbl') // Make sure this matches your car table name
                  ->onDelete('cascade');
                  
                  
            // Index for performance
            $table->index('car_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_pricing');
    }
}