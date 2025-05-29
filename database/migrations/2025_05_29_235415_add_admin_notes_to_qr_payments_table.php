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
        Schema::table('qr_payments', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('verified_at');
        });
    }

    public function down()
    {
        Schema::table('qr_payments', function (Blueprint $table) {
            $table->dropColumn('admin_notes');
        });
    }

};
