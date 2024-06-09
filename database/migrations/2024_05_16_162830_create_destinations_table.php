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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('village_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->longText('description');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('manager')->nullable();
            $table->text('category')->nullable();
            $table->text('facilities')->nullable();
            $table->string('thumbnail');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
