<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('forwarded_announcements', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('announcement_id');
        $table->string('title');
        $table->text('message');
        $table->string('location')->nullable();
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->string('barangay');
        $table->unsignedBigInteger('forwarded_by')->nullable();
        $table->timestamps();

        $table->foreign('announcement_id')->references('id')->on('announcements')->onDelete('cascade');
        $table->foreign('forwarded_by')->references('id')->on('users')->onDelete('set null');
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forwarded_announcements');
    }
};
