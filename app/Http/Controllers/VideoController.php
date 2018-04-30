<?php

namespace App\Http\Controllers;

use Auth;
use DateTime;

use App\User;
use App\Human;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function new()
    {
        $user = Auth::user();
        $human = $user->human;

        if (!$human) {
            return redirect('/');
        }

        return view('videos.new', [
            'human_id' => $human->id
        ]);
    }

    public function upload(Request $request)
    {
        $user = Auth::user();
        $video_id = $request->input('videoId');
        $video = Video::find($video_id);
        $original_file = $request->file('video');
        $tmp_dir = sys_get_temp_dir();
        $mime_type = $original_file->getClientMimeType();
        $date = new DateTime;
        $original_filename = $original_file->getClientOriginalName();
        $filename = $user->id . "-" . $date->getTimestamp() . "-". str_replace([' ', '(', ')', '%'], '', $original_filename);
        
        // move the file to tmp so we can start processing
        $moved_file = $original_file->move($tmp_dir, $filename);

        // Create video data on table
        if (!$video) {
            $video = new Video;
        }
        
        $video->file_name = $filename;
        $video->processing_complete = false;
        $video->human_id = $user->human->id;

        $video->save();

        // Let's queue it up
        $this->dispatch(new \App\Jobs\ProcessVideo($video));
        
        return $video;
    }
}
