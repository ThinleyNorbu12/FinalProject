<?php
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateQrPaymentsTable extends Migration
// {
//     public function up()
//     {
//         // Drop existing table if it exists
//         Schema::dropIfExists('qr_payments');
        
//         // Create the table with correct foreign key
//         Schema::create('qr_payments', function (Blueprint $table) {
//             $table->id();

//             // Changed to reference car_bookings table
//             $table->foreignId('payment_id')
//                 ->constrained('car_bookings')
//                 ->onDelete('cascade');

//             // Bank code options
//             $table->enum('bank_code', ['bob', 'bnb', 'tbank', 'dpnb', 'bdbl']);

//             // Optional screenshot of the payment
//             $table->string('screenshot_path')->nullable();

//             // Verification status by admin/staff
//             $table->enum('verification_status', ['pending', 'confirmed', 'rejected'])->default('pending');

//             // Verified by (customer table)
//             $table->foreignId('verified_by')
//                 ->nullable()
//                 ->constrained('users') // Changed to users table which is more common for admin/staff
//                 ->onDelete('set null');

//             $table->timestamp('verified_at')->nullable();

//             $table->timestamps();
//         });
//     }

//     public function down()
//     {
//         Schema::dropIfExists('qr_payments');
//     }
// }


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrPaymentsTable extends Migration 
{
    public function up()
    {
        // Drop existing table if it exists
        Schema::dropIfExists('qr_payments');
        
        // Create the table with correct foreign key
        Schema::create('qr_payments', function (Blueprint $table) {
            $table->id();
            
            // Modified to reference payments table - THIS IS THE KEY CHANGE
            $table->foreignId('payment_id')
                ->constrained('payments')
                ->onDelete('cascade');
            
            // Bank code options
            $table->enum('bank_code', ['bob', 'bnb', 'tbank', 'dpnb', 'bdbl']);
            
            // Optional screenshot of the payment
            $table->string('screenshot_path')->nullable();
            
            // Verification status by admin/staff
            $table->enum('verification_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            
            // Verified by
            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            $table->timestamp('verified_at')->nullable();
            $table->text('admin_notes')->nullable(); // Including admin_notes here directly
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('qr_payments');
    }
}