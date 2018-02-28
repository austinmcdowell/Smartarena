<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('file_name')->nullable();
            $table->string('file_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->enum('run_type', ['teamroping'])->nullable();
            $table->integer('run_id')->unsigned()->nullable();
            $table->boolean('processing_complete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
