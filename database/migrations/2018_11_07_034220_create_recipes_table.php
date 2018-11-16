<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('category_id');
            $table->integer('cost');
            $table->integer('prep_time');
            $table->integer('cook_time');
            $table->text('description')->nullable();
            $table->text('ingredient')->nullable();
            $table->text('instruction')->nullable();
            $table->integer('active');
            $table->string('suitable_for')->nullable();
            $table->text('name_img')->nullable();
            $table->text('link_img')->nullable();
            $table->text('link_youtube')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recipes');
    }
}
