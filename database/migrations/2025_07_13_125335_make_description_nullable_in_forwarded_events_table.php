<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('forwarded_events', function (Blueprint $table) {
            $table->time('event_time')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('forwarded_events', function (Blueprint $table) {
            $table->dateTime('event_time')->nullable()->change(); // or whatever the previous type was
        });
    }
};

