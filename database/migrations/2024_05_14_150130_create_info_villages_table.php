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
        Schema::create('info_villages', function (Blueprint $table) {
            $table->id();
            $table->string('village_id');
            $table->longText('profile')->nullable();
            $table->string('profile_img')->nullable();
            $table->longText('welcoming')->nullable();
            $table->string('welcoming_img')->nullable();
            $table->longText('destination')->nullable();
            $table->string('destination_img')->nullable();
            $table->longText('accomodation')->nullable();
            $table->string('accomodation_img')->nullable();
            $table->longText('transportation')->nullable();
            $table->string('transportation_img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_villages');
    }
};
