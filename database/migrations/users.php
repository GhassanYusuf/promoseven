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
            // $table->id();
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            // $table->rememberToken();
            // $table->timestamps();
            
            $table->id();
            $table->string('name')->nullable();
            $table->enum('accesslevel', ['A', 'H', 'M', 'S', 'E'])->nullable();   // Admin, HR, Manager, Supervisor, Employee

            $table->string('rfid', 10)->unique()->nullable();
            $table->string('zktid', 10)->unique()->nullable();
            $table->string('code', 10)->unique()->nullable();

            $table->integer('position')->nullable();
            $table->string('contact', 100)->nullable();
            $table->integer('company')->nullable();

            $table->string('cpr', 10)->nullable();
            $table->date('cpr_expire')->nullable();

            $table->string('passport', 30)->nullable();
            $table->date('passport_expire')->nullable();

            $table->string('visa', 30)->nullable();
            $table->date('visa_expire')->nullable();

            $table->string('nationality')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->date('birthdate')->nullable();

            $table->date('join_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('bank_account', 100)->nullable();
            $table->string('picture', 100)->nullable();

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
