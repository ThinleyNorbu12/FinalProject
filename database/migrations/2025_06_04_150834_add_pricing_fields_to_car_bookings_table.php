<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricingFieldsToCarBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('car_bookings', function (Blueprint $table) {
            $table->decimal('rate_per_day', 10, 2)->comment('Daily rental rate');
            $table->decimal('price_per_km', 8, 2)->nullable()->comment('Price per km for exceeding mileage limit');
            
            // Add index for rate_per_day for performance
            $table->index('rate_per_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_bookings', function (Blueprint $table) {
            $table->dropIndex(['rate_per_day']);
            $table->dropColumn(['rate_per_day', 'price_per_km']);
        });
    }
}