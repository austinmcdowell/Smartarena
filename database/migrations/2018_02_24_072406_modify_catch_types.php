<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCatchTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teamroping_runs', function (Blueprint $table) {
            $table->dropColumn('header_catch_type');
            $table->dropColumn('heeler_catch_type');
            $table->dropColumn('header_penalty_type');
            $table->dropColumn('heeler_penalty_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teamroping_runs', function (Blueprint $table) {
            $table->enum('header_catch_type', ['half head', 'two horns', 'slick horns'])->nullable();
            $table->enum('heeler_catch_type', ['clean', 'head'])->nullable();
            $table->enum('header_penalty_type', ['none', 'barrier', 'disqualification'])->nullable();
            $table->enum('heeler_penalty_type', ['none', 'barrier', 'leg'])->nullable();
        });
    }
}
