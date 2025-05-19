<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQrPaymentsVerifiedByForeignKey extends Migration
{
    public function up()
    {
        Schema::table('qr_payments', function (Blueprint $table) {
            // First, drop the existing foreign key constraint
            $table->dropForeign(['verified_by']);
            
            // Then re-create it with the correct reference to admins table
            $table->foreign('verified_by')
                ->references('id')
                ->on('admins')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('qr_payments', function (Blueprint $table) {
            // Reverse the changes - drop the admins foreign key
            $table->dropForeign(['verified_by']);
            
            // Restore the original reference to users table
            $table->foreign('verified_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }
}