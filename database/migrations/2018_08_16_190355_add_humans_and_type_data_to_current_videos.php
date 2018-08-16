<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Video;
use App\Human;

class AddHumansAndTypeDataToCurrentVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $videos = Video::all();

        foreach ($videos as $video) {
            $video->run_type = "teamroping";
            $run = $video->run;
        
            if (isset($run) && $run !== null) {
                $video->human_id = $run->stats['header']['human_id'];
            }
            
            $video->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $videos = Video::all();

        foreach ($videos as $video) {
            $video->run_type = null;
            $video->human_id = null;
            $video->save();
        }
    }
}
