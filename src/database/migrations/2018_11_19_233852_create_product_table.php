<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
                  $table->increments('id');
                  $table->string('uuid',32);
                  $table->string('name',100);
                  $table->string('slug',100);
                  $table->integer('category_id')->unsigned();
                  $table->foreign('category_id')
                            ->references('id')
                            ->on('categories');
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
        Schema::dropIfExists('product');
    }
}
