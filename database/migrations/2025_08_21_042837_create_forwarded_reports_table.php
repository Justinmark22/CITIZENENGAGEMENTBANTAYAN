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
    Schema::create('forwarded_reports', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('report_id'); // links to reports table
        $table->string('forwarded_to'); // e.g. Santa.Fe MDRRMO
        $table->text('remarks')->nullable();
        $table->timestamps();

        $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('forwarded_reports');
}
};
