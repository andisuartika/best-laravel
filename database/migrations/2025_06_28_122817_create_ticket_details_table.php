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
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_detail_id');
            $table->string('ticket_code', 64)->unique();
            $table->boolean('is_used')->default(false);
            $table->dateTime('used_at')->nullable();
            $table->timestamps();

            $table->foreign('booking_detail_id')->references('id')->on('booking_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_details');
    }
};
