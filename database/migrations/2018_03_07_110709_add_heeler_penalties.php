<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeelerPenalties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teamroping_runs', function (Blueprint $table) {
            $table->enum('heeler_penalty_type', ['disqualification', 'leg', 'missed'])->nullable();
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
            $table->dropColumn('heeler_penalty_type');
        });
    }
}
