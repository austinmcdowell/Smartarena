<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCatchTypesAndPenalties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teamroping_runs', function (Blueprint $table) {
            $table->enum('header_catch_type', ['slick horns', 'neck', 'half head'])->nullable();
            $table->enum('heeler_catch_type', ['clean'])->nullable();
            $table->enum('header_penalty_type', ['disqualification'])->nullable();
            $table->enum('heeler_penalty_type', ['disqualification', 'leg'])->nullable();
            
            $table->integer('header_barrier_penalty')->unsigned()->default(0);
            $table->integer('heeler_barrier_penalty')->unsigned()->default(0);
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
            $table->dropColumn('header_catch_type');
            $table->dropColumn('heeler_catch_type');
            $table->dropColumn('header_penalty_type');
            $table->dropColumn('heeler_penalty_type');

            $table->dropColumn('header_barrier_penalty');
            $table->dropColumn('heeler_barrier_penalty');
        });
    }
}
