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

            // Feilds
            $table->id();
            $table->unsignedBigInteger('eid')->nullable();      // Employee ID
            $table->unsignedBigInteger('did')->nullable();      // Department ID
            $table->unsignedBigInteger('vid')->nullable();      // Visa Source
            $table->date('visa_expire')->nullable();            // Visa Expire
            $table->string('position', 45)->nullable(); // Position Title
            $table->enum('accesslevel', ['A', 'H', 'M', 'S', 'E'])->nullable();   // Admin, HR, Manager, Supervisor, Employee
            $table->json('duties')->nullable();                 // Text Of Responsibilitis
            $table->float('salary')->nullable();                // Salary Amount
            $table->json('allowances')->nullable();             // Allowances
            $table->json('benefits')->nullable();               // Allowances
            $table->json('documents')->nullable();              // Attached Documents
            $table->date('start_date')->nullable();             // Start/Effective Date
            $table->date('end_date')->nullable();               // Contract End Date
            $table->integer('doneBy')->nullable();              // The Person Who Created the Entry
            $table->boolean('terminated')->default(false)->nullable();
            $table->timestamps();

            // Forign Key In Employees ID
            $table->foreign('eid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            // Forign Key In Visa Source ID
            $table->foreign('vid')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');

            // Forign Key In Department ID
            $table->foreign('did')->references('id')->on('companies_departments')->onUpdate('cascade')->onDelete('cascade');

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
