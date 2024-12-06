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

        if ( !Schema::hasTable('announcements') ) {

            Schema::create('announcements', function (Blueprint $table) {

                $table->id();
                $table->string('title', 50);
                $table->string('body', 255)->nullable();
                $table->json('attachment')->nullable();
                $table->date('start_date');
                $table->date('end_date');
                $table->timestamps();

            });

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down() {

        Schema::dropIfExists('announcements');

    }
};
