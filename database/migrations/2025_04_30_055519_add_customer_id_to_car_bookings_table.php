<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdToCarBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('car_bookings', function (Blueprint $table) {
            // Add customer_id column after car_id
            $table->unsignedBigInteger('customer_id')->after('car_id')->nullable();
            
            // Add foreign key constraint (if you have a customers table)
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers') // Change this if your table has a different name
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_bookings', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['customer_id']);
            
            // Then drop the column
            $table->dropColumn('customer_id');
        });
    }
}