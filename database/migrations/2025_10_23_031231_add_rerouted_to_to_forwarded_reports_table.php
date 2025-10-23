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
    Schema::table('forwarded_reports', function (Blueprint $table) {
        $table->string('rerouted_to')->nullable()->after('forwarded_to');
    });
}


    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('forwarded_reports', function (Blueprint $table) {
        $table->dropColumn('rerouted_to');
    });
}

    
};
