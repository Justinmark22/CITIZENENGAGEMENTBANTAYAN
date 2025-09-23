<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rerouted_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id'); // original report ID
            $table->string('category');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->string('status'); // e.g. Pending, Ongoing, Resolved
            $table->string('forwarded_to'); // department / office it was rerouted to
            $table->string('location');
            $table->unsignedBigInteger('user_id'); // reporter / user
            $table->timestamps();

            // 🔗 Foreign keys
            $table->foreign('report_id')->references('id')->on('forwarded_reports')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rerouted_reports');
    }
};
