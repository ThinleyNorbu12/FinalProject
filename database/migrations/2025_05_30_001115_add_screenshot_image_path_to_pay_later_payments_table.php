<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScreenshotImagePathToPayLaterPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('pay_later_payments', function (Blueprint $table) {
            $table->string('screenshot_image_path')->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('pay_later_payments', function (Blueprint $table) {
            $table->dropColumn('screenshot_image_path');
        });
    }
}

