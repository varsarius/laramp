<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('location_id')->nullable();
          $table->string('name');
          $table->string('description')->nullable(); // переделать string на text
          //$table->string('location');
          $table->date('date')->nullable();
          $table->string('path');
          $table->boolean('is_verified')->default(0);
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
        Schema::dropIfExists('images');
    }
}
