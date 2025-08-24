<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('forwarded_events', function (Blueprint $table) {
            $table->string('category')->default('General'); // or remove ->default() if setting manually later
        });
    }

    public function down()
    {
        Schema::table('forwarded_events', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
