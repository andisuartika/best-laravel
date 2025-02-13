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
        Schema::create('destination_prices', function (Blueprint $table) {
            $table->id();
            $table->string('village_id');
            $table->string('destination_id');
            $table->foreignId('manager')->nullable()->constrained('users')->onDelete('set null');
            $table->string('code');
            $table->string('name');
            $table->text('description');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_prices');
    }
};
