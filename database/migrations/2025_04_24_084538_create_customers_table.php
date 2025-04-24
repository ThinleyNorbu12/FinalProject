<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();  // Automatically creates an auto-incrementing ID
            $table->string('name');  // Name of the customer
            $table->string('email')->unique();  // Unique email address
            $table->string('phone')->unique();  // Unique phone number
            $table->string('cid_no')->unique();  // Unique CID number
            $table->string('password')->nullable();  // Password (nullable initially)
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
