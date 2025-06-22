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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('booking_date');
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_status')->default('pending');
            $table->string('booking_status')->default('pending');
            $table->string('booking_code')->unique();
            $table->text('special_req')->nullable();
            $table->integer('guest_count')->default(1);
            $table->unsignedBigInteger('manager')->nullable();
            $table->string('payment_channel')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
