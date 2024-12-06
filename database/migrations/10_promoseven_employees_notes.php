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

            // Feild
            $table->id();
            $table->unsignedBigInteger('eid')->nullable();
            $table->string('title', 45)->nullable();
            $table->string('content', 150)->nullable();
            $table->unsignedBigInteger('done_by')->nullable();
            $table->timestamps();

            // Forign Key In Employee
            $table->foreign('eid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            // Forign Key In Action Done By
            $table->foreign('done_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

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
