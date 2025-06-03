<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('slug')->unique()->after('code');
        });

        Schema::table('homestays', function (Blueprint $table) {
            $table->string('slug')->unique()->after('code');
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->string('slug')->unique()->after('code');
        });

        Schema::table('transportations', function (Blueprint $table) {
            $table->string('slug')->unique()->after('code');
        });
    }

    public function down()
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('homestays', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('transportations', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
