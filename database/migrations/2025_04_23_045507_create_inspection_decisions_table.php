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
        Schema::create('inspection_decisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspection_request_id')->unique();
            $table->enum('decision', ['approved', 'rejected']);
            $table->unsignedBigInteger('admin_id'); // Who made the decision
            $table->timestamps();
            $table->foreign('inspection_request_id')->references('id')->on('inspection_requests')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_decisions');
    }
};
