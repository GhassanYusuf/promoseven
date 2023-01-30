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

    public function up() {
        Schema::create('employees_uppraisals', function (Blueprint $table) {
            $table->id();
            $table->integer('eid')->nullable();                 // Employee ID
            $table->integer('did')->nullable();                 // Department ID
            $table->integer('vid')->nullable();                 // Visa Source
            $table->date('visa_expire')->nullable();            // Visa Expire
            $table->string('position', 45)->nullable();         // Position Title
            $table->json('duties')->nullable();                 // Text Of Responsibilitis
            $table->float('salary')->nullable();                // Salary Amount
            $table->json('allowances')->nullable();             // Allowances
            $table->json('benefits')->nullable();               // Allowances
            $table->json('documents')->nullable();              // Attached Documents
            $table->date('start_date')->nullable();             // Start/Effective Date
            $table->date('end_date')->nullable();               // Contract End Date
            $table->integer('doneBy')->nullable();              // The Person Who Created the Entry
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down() {
        Schema::dropIfExists('employees_uppraisals');
    }
};
