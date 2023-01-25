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
            $table->integer('cid');                 // Companies ID
            $table->integer('pdid')->nullable();    // Parent Department ID
            $table->integer('mid')->nullable();     // Department Manager ID
            $table->string('name');                 // Title Of the Department
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
        Schema::dropIfExists('companies_departments');
    }
};
