<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixQrPaymentsForeignKey extends Migration
{
    public function up()
    {
        Schema::table('qr_payments', function (Blueprint $table) {
            // Drop the existing foreign key constraint first
            $table->dropForeign(['payment_id']);
            
            // Then re-create it with the correct reference
            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('qr_payments', function (Blueprint $table) {
            // Reverse the changes if needed
            $table->dropForeign(['payment_id']);
            
            // Restore the original reference (though not recommended)
            $table->foreign('payment_id')
                ->references('id')
                ->on('car_bookings')
                ->onDelete('cascade');
        });
    }
}