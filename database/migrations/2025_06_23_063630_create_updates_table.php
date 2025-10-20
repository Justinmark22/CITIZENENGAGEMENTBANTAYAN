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
    Schema::create('updates', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('message');
        $table->string('location')->nullable(); // optional if you want per-location updates
        $table->date('update_date')->nullable(); // add a date column
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('updates');
    }
};
