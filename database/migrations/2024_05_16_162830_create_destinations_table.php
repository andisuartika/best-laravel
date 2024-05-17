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
            $table->string('description');
            $table->string('adress');
            $table->string('latitude');
            $table->string('longtitude');
            $table->string('manager')->nullable();
            $table->string('category')->nullable();
            $table->string('facilities')->nullable();
            $table->string('oprational')->nullable();
            $table->string('thumbnail');
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
