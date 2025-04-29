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
    Schema::create('inspection_requests', function (Blueprint $table) {
        $table->engine = 'InnoDB'; // Ensure the table uses InnoDB
        $table->id();
        $table->unsignedBigInteger('car_id');
        $table->date('inspection_date');
        $table->time('inspection_time');
        $table->string('location');
        $table->text('details')->nullable();
        $table->enum('status', ['available', 'booked', 'canceled'])->default('available');
        $table->timestamps();
    
        $table->foreign('car_id')->references('id')->on('car_details')->onDelete('cascade');
    });
    
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_requests');
    }
};
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     public function up()
//     {
//         Schema::create('inspection_requests', function (Blueprint $table) {
//             $table->engine = 'InnoDB';
//             $table->id();
//             $table->unsignedBigInteger('car_id');
//             $table->date('inspection_date');
//             $table->time('inspection_time');
//             $table->string('location');
//             $table->text('details')->nullable();
//             $table->enum('status', ['available', 'booked', 'canceled'])->default('available');
//             $table->timestamps();

//             // Fix here
//             $table->foreign('car_id')->references('id')->on('car_details_tbl')->onDelete('cascade');
//         });
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('inspection_requests');
//     }
// };
