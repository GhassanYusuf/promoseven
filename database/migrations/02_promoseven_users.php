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

            // Name RFID Tag, Employee Code, Contact Information, Feidls
            $table->id();
            $table->string('name')->nullable();
            $table->string('rfid', 10)->unique()->nullable();
            $table->string('code', 10)->unique()->nullable();
            $table->json('contact')->nullable();
            $table->json('qualifications')->nullable();

            // CPR & PASSPORT - ID Of Employee
            $table->string('cpr', 10)->nullable();
            $table->date('cpr_expire')->nullable();
            $table->string('passport', 30)->nullable();
            $table->date('passport_expire')->nullable();
            $table->string('nationality', 3)->nullable();
            $table->enum('gender', ['M', 'F'])->default('M')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('bank_account', 100)->nullable();
            $table->string('picture', 100)->nullable();

            // Authentication
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();

            // Tracking Changes Vs Time
            $table->timestamps();

            // Forign Key In Nationality
            $table->foreign('nationality')->references('iso3')->on('countries')->onUpdate('cascade')->onDelete('cascade');

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
