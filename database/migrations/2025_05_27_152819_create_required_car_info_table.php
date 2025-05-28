<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('required_car_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            
            // Vehicle & Owner Info
            $table->string('vehicle_registration_number');
            $table->string('owner_license_number'); // for verification
            
            // Required documents/certificates
            $table->boolean('valid_registration')->default(false);
            $table->boolean('insurance_valid')->default(false);
            $table->boolean('road_tax_paid')->default(false);
            $table->boolean('fitness_certificate')->default(false);
            $table->boolean('pollution_certificate')->default(false);
            
            // Exterior Condition
            $table->text('scratches')->nullable();
            $table->text('dents')->nullable();
            $table->text('cracked_lights_or_mirrors')->nullable();
            $table->enum('tire_condition', ['excellent', 'good', 'fair', 'poor', 'needs_replacement'])->nullable();
            $table->boolean('body_exterior_acceptable')->default(false);
            
            // Interior Condition
            $table->text('seat_dashboard_condition')->nullable();
            $table->boolean('ac_working')->default(false);
            $table->boolean('interior_condition_good')->default(false);
            
            // Mechanical & Safety (Removed duplicates)
            $table->boolean('engine_condition_good')->default(false);
            $table->boolean('brakes_functional')->default(false); // Combined brake fields
            $table->boolean('lights_working')->default(false); // Combined light fields
            $table->boolean('horn_working')->default(false);
            $table->boolean('no_engine_warning_lights')->default(false);
            $table->boolean('indicators_wipers_working')->default(false);
            $table->boolean('safety_features_working')->default(false);
            
            // Accessories & Tools
            $table->boolean('spare_tire_available')->default(false);
            $table->boolean('jack_available')->default(false);
            
            // Fuel
            $table->enum('initial_fuel_level', ['full', 'three_quarter', 'half', 'quarter', 'empty'])->nullable();
            
            // Additional info and status
            $table->text('additional_notes')->nullable();
            $table->enum('overall_status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
            
            $table->foreign('car_id')->references('id')->on('car_details_tbl')->onDelete('cascade');
            $table->unique('car_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('required_car_info');
    }
};