<?php

namespace App\Jobs;

use App\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tmp_dir = sys_get_temp_dir();
        $filename = $this->video->file_name;
        $transcoded_filename = basename($filename, ".mp4") . "-transcoded.mp4";
        $thumbnail_filename  = basename($filename, ".mp4") . "-thumbnail.png";
        $space_url = "https://" . env("DO_SPACES_BUCKET") . "." . env("DO_SPACES_REGION") . ".digitaloceanspaces.com/";

        // transcode the video
        exec("ffmpeg -i " . $tmp_dir . "/" . $filename . " -g 30 -r 60 -s 1280x720 -preset ultrafast -b:v 5000k -minrate 4000k -maxrate 5000k -bufsize 99000k -deblock 6:6  -vcodec libx264 -movflags +faststart -strict -2 -y " . $tmp_dir . "/" . $transcoded_filename);

        // generate the thumbnail
        exec("ffmpeg -i ". $tmp_dir . "/" . $filename . " -ss 00:00:01 -s 400x275 -vframes 1 " . $tmp_dir . "/" . $thumbnail_filename);

        Storage::disk('spaces')->putFileAs('videos', new File($tmp_dir . "/" . $transcoded_filename), $transcoded_filename, "public");
        Storage::disk('spaces')->putFileAs('thumbnails', new File($tmp_dir . "/" . $thumbnail_filename), $thumbnail_filename, "public");
        Storage::disk('spaces')->putFileAs('original_backups', new File($tmp_dir . "/" . $filename), $filename);

        $this->video->file_url = $space_url . "videos/" . $transcoded_filename;
        $this->video->thumbnail_url = $space_url . "thumbnails/" . $thumbnail_filename;
        $this->video->processing_complete = true;

        $this->video->save();
    }
}
