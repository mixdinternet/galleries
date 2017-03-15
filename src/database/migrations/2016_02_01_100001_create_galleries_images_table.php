<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesImagesTable extends Migration
{
    public function up()
    {
        Schema::create('galleries_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gallery_id')->unsigned()->index();
            $table->string('name');
            $table->string('description')->default('');
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();

            #$table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('galleries_images');
    }
}
