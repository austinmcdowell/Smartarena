<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamropingRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teamroping_runs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('date');
            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events');
            $table->decimal('total_time', 8,2);

            $table->boolean('header_did_catch')->nullable();
            $table->enum('header_catch_type', ['half head', 'two horns', 'slick horns'])->nullable();
            $table->integer('header_penalty_time')->nullable();
            $table->enum('header_penalty_type', ['none', 'barrier', 'disqualification'])->nullable();
            $table->integer('header_human_id')->unsigned()->nullable();
            $table->foreign('header_human_id')->references('id')->on('humans');

            $table->boolean('heeler_did_catch')->nullable();
            $table->enum('heeler_catch_type', ['clean', 'head'])->nullable();
            $table->integer('heeler_penalty_time')->nullable();
            $table->enum('heeler_penalty_type', ['none', 'barrier', 'leg'])->nullable();
            $table->integer('heeler_human_id')->unsigned()->nullable();
            $table->foreign('heeler_human_id')->references('id')->on('humans');

            $table->decimal('raw_time', 8, 2);
            $table->string('roping')->nullable();
            $table->string('round')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teamroping_runs');
    }
}
