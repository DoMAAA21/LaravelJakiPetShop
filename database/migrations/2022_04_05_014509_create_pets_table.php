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


        Schema::create('breed', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
        });

        Schema::create('pets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('breed_id')->unsigned();
            $table->foreign('breed_id')->references('id')->on('breed');
            $table->text('pet_name');
            $table->text('gender');
            $table->integer('pet_age');
            $table->integer('owner_id')->unsigned()->nullable();
            $table->foreign('owner_id')->references('id')->on('customers')->OnDelete('cascade');
            $table->string('img_path')->default('pet.jpg');
            $table->timestamps();
            $table->softDeletes();
        });


       
       

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        
        Schema::dropIfExists('pets');
        Schema::dropIfExists('breed');
    }
};
