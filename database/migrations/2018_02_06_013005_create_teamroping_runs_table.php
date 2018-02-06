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

            $table->boolean('header_did_catch');
            $table->enum('header_catch_type', ['missed', 'half head', 'two horns', 'slick horns']);
            $table->integer('header_penalty_time');
            $table->enum('header_penalty_type', ['none', 'barrier', 'disqualification']);
            $table->integer('header_user_id')->unsigned();
            $table->foreign('header_user_id')->references('id')->on('users');

            $table->boolean('heeler_did_catch');
            $table->enum('heeler_catch_type', ['missed', 'clean', 'head']);
            $table->integer('heeler_penalty_time');
            $table->enum('heeler_penalty_type', ['none', 'barrier', 'leg']);
            $table->integer('heeler_user_id')->unsigned();
            $table->foreign('heeler_user_id')->references('id')->on('users');

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
