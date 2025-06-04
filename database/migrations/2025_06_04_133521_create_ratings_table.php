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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation
            $table->unsignedBigInteger('rateable_id');
            $table->string('rateable_type'); // Model class name
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('booking_code')->nullable();
            $table->decimal('rating', 2, 1);
            $table->text('review')->nullable();

            $table->timestamps();

            $table->index(['rateable_id', 'rateable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
