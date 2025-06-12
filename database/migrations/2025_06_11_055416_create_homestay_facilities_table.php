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
        Schema::create('homestay_facilities', function (Blueprint $table) {
            $table->id();

            $table->string('homestay_code');
            $table->unsignedBigInteger('facility_id');

            $table->foreign('homestay_code')->references('code')->on('homestays')->onDelete('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homestay_facilities');
    }
};
