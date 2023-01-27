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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);                         // Name Of the Company
            $table->string('logo', 100)->nullable();            // Company Logo
            $table->string('cr', 45)->unique()->nullable();     // CR Number
            $table->json('attachment')->nullable();             // CR Attachment
            $table->date('expire')->nullable();                 // Expire Date
            $table->string('vat', 100)->nullable();             // VAT Number
            $table->string('parent', 45)->nullable();           // Parent Company ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down() {
        Schema::dropIfExists('companies');
    }
};
