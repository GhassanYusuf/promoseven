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

        Schema::create('employees_notes', function (Blueprint $table) {
            $table->id();
            $table->integer('eid')->nullable();
            $table->string('title', 45)->nullable();
            $table->string('content', 150)->nullable();
            $table->integer('done_by')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down() {

        Schema::dropIfExists('employees_notes');
        
    }
};
