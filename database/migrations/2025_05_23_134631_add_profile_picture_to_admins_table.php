<?php

// Create this migration file: database/migrations/xxxx_xx_xx_add_profile_picture_to_admins_table.php
// Run: php artisan make:migration add_profile_picture_to_admins_table

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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('profile_picture');
        });
    }
};