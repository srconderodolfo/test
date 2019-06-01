<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsbudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_budgets', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('budget_id')->unsigned();
            $table->foreign('budget_id')
                ->references('id')
                ->on('budgets');

            $table->integer('details_catalogs_id')->unsigned();
            $table->foreign('details_catalogs_id')
                ->references('id')
                ->on('details_catalogs');

            $table->tinyInteger('quantity');
            $table->dateTime('finished_at')->nullable();
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
        Schema::table('details_budgets', function (Blueprint $table) {
            //
        });
    }
}
