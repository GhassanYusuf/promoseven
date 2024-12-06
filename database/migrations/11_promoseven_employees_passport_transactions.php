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

        Schema::create('employees_passport_transactions', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('eid');
            $table->enum('state', ['IN', 'OUT'])->nullable();
            $table->string('note', 100)->nullable();
            $table->integer('done_by');
            $table->timestamps();

            // Forign Key In RFID
            $table->foreign('eid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down() {
        Schema::dropIfExists('employees_passport_transactions');
    }

};
