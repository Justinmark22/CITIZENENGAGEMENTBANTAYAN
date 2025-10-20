<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_requests', function (Blueprint $table) {
            $table->id();

            // User reference (if logged in)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            // Personal Info
            $table->string('full_name');
            $table->date('birthdate');
            $table->string('gender');
            $table->string('civil_status');
            $table->string('address');
            $table->string('location'); // ✅ Added location
            $table->string('contact')->nullable();
            $table->string('email')->nullable();

            // Certificate Details
            $table->string('certificate_type'); 
            $table->json('certificate_data');   

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_requests');
    }
};


