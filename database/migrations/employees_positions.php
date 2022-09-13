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

        Schema::create('employees_positions', function (Blueprint $table) {

            $table->id();                           // ID
            $table->integer('eid');                 // Employee ID -> is User ID
            $table->integer('cid');                 // Company ID -> is Companies ID
            $table->integer('vid');                 // Visa ID -> is Employees Visas ID
            $table->integer('did')->nullable();     // Departments ID -> is Companies Department ID
            $table->string('position', 45);         // Position Tile
            $table->float('salary');                // Salary Of The Position
            $table->string('duties');               // This List Of Responabilities
            $table->integer('done_by');             // Person Who Created This Record
            $table->timestamps();                   // Time Stamp
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down() {
        Schema::dropIfExists('employees_positions');
    }
};
