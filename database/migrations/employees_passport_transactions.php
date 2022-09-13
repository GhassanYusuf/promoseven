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
            $table->integer('eid');
            $table->enum('state', ['IN', 'OUT']);
            $table->string('note', 50)->nullable();
            $table->integer('done_by');
            $table->timestamps();
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
