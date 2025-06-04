<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMileageFieldsToCarBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('car_bookings', function (Blueprint $table) {
            $table->unsignedInteger('mileage_limit')->nullable()->comment('Daily mileage limit in km/miles');
            $table->unsignedInteger('current_mileage')->nullable()->comment('Current vehicle mileage at booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_bookings', function (Blueprint $table) {
            $table->dropColumn(['mileage_limit', 'current_mileage']);
        });
    }
}