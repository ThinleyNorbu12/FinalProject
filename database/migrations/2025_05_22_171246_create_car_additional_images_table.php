<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarAdditionalImagesTable extends Migration
{
    public function up()
    {
        Schema::create('car_additional_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('admin_cars_tbl')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('car_additional_images');
    }
}