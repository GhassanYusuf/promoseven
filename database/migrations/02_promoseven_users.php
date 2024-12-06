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
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('name')->nullable();

            $table->string('rfid', 10)->unique()->nullable();
            $table->string('code', 10)->unique()->nullable();

            $table->string('contact', 100)->nullable();
            $table->integer('company')->nullable();

            $table->string('cpr', 10)->nullable();
            $table->date('cpr_expire')->nullable();

            $table->string('passport', 30)->nullable();
            $table->date('passport_expire')->nullable();

            $table->unsignedBigInteger('nationality')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->date('birthdate')->nullable();

            $table->string('bank_account', 100)->nullable();
            $table->string('picture', 100)->nullable();

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Forign Key In Nationality
            $table->foreign('nationality')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
