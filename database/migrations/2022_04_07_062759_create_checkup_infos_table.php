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

        Schema::create('diseases', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('description');
        });



        Schema::create('checkup_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('disease_id')->unsigned();
            $table->foreign('disease_id')->references('id')->on('diseases');
            $table->integer('pet_id')->unsigned();
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->string('comments')->nullable();
            $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));

         
        });




      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkup_infos');
        Schema::dropIfExists('diseases');
    }
};
