<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('street');
            $table->smallInteger('number')->nullable();
            $table->string('complement',100)->nullable();
            $table->string('neighborhood',100)->nullable();
            $table->string('city',100)->nullable();
            $table->char('state',2)->nullable();
            $table->char('zip_code',8);
            $table->boolean('active')->default(1);
            $table->foreign('student_id')->references('id')->on('students');
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
        Schema::dropIfExists('addresses');
    }
}
