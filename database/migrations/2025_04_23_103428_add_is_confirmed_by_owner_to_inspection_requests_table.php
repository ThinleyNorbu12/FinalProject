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
        Schema::table('inspection_requests', function (Blueprint $table) {
            $table->boolean('is_confirmed_by_owner')->default(0);
        });
    }

    public function down()
    {
        Schema::table('inspection_requests', function (Blueprint $table) {
            $table->dropColumn('is_confirmed_by_owner');
        });
    }

};
