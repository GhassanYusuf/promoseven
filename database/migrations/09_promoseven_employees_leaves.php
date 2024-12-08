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
        Schema::create('employees_leaves', function (Blueprint $table) {

            // Feilds
            $table->id();
            $table->unsignedBigInteger('eid')->nullable();
            $table->enum('type', ['A', 'S', 'U', 'P', 'M', 'C'])->nullable();   // Annual / Sick / Unpaid / Paternity / Maternity / Compasionate
            $table->date('start_date')->nullable();
            $table->date('return_date')->nullable();
            $table->enum('status', ['O', 'R'])->nullable();
            $table->unsignedBigInteger('employee_incharge')->nullable();
            $table->enum('annual_ticket', ['Y', 'N'])->nullable();
            $table->string('destination', 45)->nullable();
            $table->string('flight_details', 45)->nullable();
            $table->string('contact_info', 45)->nullable();
            $table->String('note', 200)->nullable();
            $table->enum('hApproval', ['A', 'R', 'C'])->nullable();        // Approved / Rejected / Pending / Canceled
            $table->enum('mApproval', ['A', 'R', 'C'])->nullable();        // Approved / Rejected / Pending / Canceled
            $table->unsignedBigInteger('hApproved_by')->nullable();                 // HR That Approved The Leave
            $table->unsignedBigInteger('mApproved_by')->nullable();                 // Manager That Approved The Leave
            $table->timestamps();

            // Forign Key In Employee
            $table->foreign('eid')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            // Forign Key In Charge
            $table->foreign('employee_incharge')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            // Forign Key In HR Approved
            $table->foreign('hApproved_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            // Forign Key In Manager Approved
            $table->foreign('mApproved_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_leaves');
    }
};
