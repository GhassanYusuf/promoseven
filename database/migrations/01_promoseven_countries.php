<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name', 80);
            $table->string('iso', 2)->unique()->nullable();
            $table->string('iso3', 3)->unique()->nullable();
            $table->integer('numcode')->nullable();
            $table->integer('phonecode')->nullable();
            $table->string('currency', 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
