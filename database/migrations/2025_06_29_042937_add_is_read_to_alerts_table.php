<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReadToAlertsTable extends Migration
{
    public function up()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->boolean('is_read')->default(false)->after('location');
        });
    }

    public function down()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
    }
}
