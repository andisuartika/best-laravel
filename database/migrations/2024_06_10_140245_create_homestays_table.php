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
        Schema::create('homestays', function (Blueprint $table) {
            $table->id();
            $table->string('village_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->longText('description');
            $table->string('manager');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('status');
            $table->string('thumbnail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homestays');
    }
};
