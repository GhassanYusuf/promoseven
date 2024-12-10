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

        Schema::create('employees_attachments', function (Blueprint $table) {

            // Feilds
            $table->id();
            $table->unsignedBigInteger('eid')->nullable();
            $table->string('cpr', 45)->nullable();
            $table->string('title', 45)->nullable();
            $table->json('attachment')->nullable();
            $table->integer('done_by')->nullable();
            $table->timestamps();

            // Forign Key In Users
            $table->foreign('eid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            // Forign Key In Users
            $table->foreign('done_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down() {

        Schema::dropIfExists('employees_attachments');

    }

};
