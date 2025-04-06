<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('car_owners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password'); // ✅ add password
            $table->text('address');
            $table->timestamp('email_verified_at')->nullable(); // ✅ add email verification
            $table->string('verification_token')->nullable(); // ✅ add verification token
            $table->rememberToken(); // ✅ adds a nullable string('remember_token')
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('car_owners');
    }
};
