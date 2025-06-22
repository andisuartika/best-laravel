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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking')->constrained('bookings')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->date('transaction_date')->nullable();
            $table->string('payment_method')->nullable(); // e.g., bank_transfer, qris
            $table->string('payment_status')->default('pending'); // pending, settlement, expire, cancel, etc
            $table->string('transaction_code')->nullable(); // internal or Midtrans reference
            $table->text('payment_proof')->nullable();
            $table->text('note')->nullable();

            // Midtrans integration
            $table->string('midtrans_order_id')->nullable();       // often same as booking_code
            $table->text('payment_token')->nullable();             // Snap token
            $table->text('payment_redirect_url')->nullable();      // for Snap redirect
            $table->string('va_number')->nullable();               // virtual account number
            $table->string('bank')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
