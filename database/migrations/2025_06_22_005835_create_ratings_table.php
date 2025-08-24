<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('service_rating'); // Stores the service rating (1-5)
            $table->text('feedback')->nullable(); // Stores optional feedback for service
            $table->string('location'); // Stores the location associated with the rating
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Stores the user who rated the service
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}