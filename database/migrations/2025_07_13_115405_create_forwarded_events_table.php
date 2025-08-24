<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('forwarded_events', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('event_id');
       $table->string('title')->nullable();

        $table->text('category');
        $table->string('location');
        $table->date('event_date');
        $table->date('event_time');
        $table->string('barangay');
        $table->unsignedBigInteger('forwarded_by');
        $table->timestamps();

        $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forwarded_events');
    }
};
