<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumanRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_run', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('human_id')->unsigned()->index();
			$table->foreign('human_id')->references('id')->on('humans');
			$table->integer('run_id')->unsigned()->index();
            $table->foreign('run_id')->references('id')->on('runs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('human_run');
    }
}
