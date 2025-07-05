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
        Schema::create('transaction_wds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('withdrawal_id')->constrained('withdrawals')->cascadeOnDelete();
            $table->decimal('amount', 18, 2);
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_wds');
    }
};
