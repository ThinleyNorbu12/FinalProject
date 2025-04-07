<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('car_owners', function (Blueprint $table) {
            $table->string('password_set_token')->nullable(); // Add this line to create the column
        });
    }
    
    public function down()
    {
        Schema::table('car_owners', function (Blueprint $table) {
            $table->dropColumn('password_set_token'); // To remove the column if you rollback the migration
        });
    }
};
