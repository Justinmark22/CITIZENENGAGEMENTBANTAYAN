<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;




class CreateSupportTable extends Migration
{
    public function up()
    {
        Schema::create('support', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Name of the person requesting support
            $table->string('email'); // Email of the person requesting support
            $table->text('message'); // Support message
            $table->timestamps(); // Automatically created 'created_at' and 'updated_at' columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('support');
    }
}
