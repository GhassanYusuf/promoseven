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
        Schema::create('companies_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cid');              // Companies ID
            $table->unsignedBigInteger('mid')->nullable();  // Department Manager ID
            $table->integer('pdid')->nullable();            // Parent Department ID
            $table->string('name', 100);            // Title Of the Department
            $table->timestamps();

            // Forign Key In Companies
            $table->foreign('cid')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');

            // Forign Key In Users
            $table->foreign('mid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_departments');
    }
};
