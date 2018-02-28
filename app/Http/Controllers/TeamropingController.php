<?php

namespace App\Http\Controllers;

use Auth;
use DateTime;
use App\Http\Controllers\Controller;
use App\Human;
use App\TeamropingRun;
use App\Event;
use App\Video;

use Illuminate\Http\Request;

class TeamropingController extends Controller
{
    public function new()
    {
        $events = Event::all();
        $humans = Human::all();
        return view('runeditor', [
            'events' => $events,
            'humans' => $humans,
            'videos' => []
        ]);
    }

    public function edit()
    {

    }

    public function create(Request $request)
    {
        $run = new TeamropingRun;
    
        $run->date = $request->input('date');
        $run->event_id = $request->input('eventId');

    }

    public function upload(Request $request)
    {
        $user = Auth::user();
        $original_file = $request->file('video');
        $tmp_dir = sys_get_temp_dir();
        $mime_type = $original_file->getClientMimeType();
        $date = new DateTime;
        $original_filename = $original_file->getClientOriginalName();
        $filename = $user->id . "-" . $date->getTimestamp() . "-". $original_filename;
    
        if ($mime_type != "video/mp4") {
            // CHOKE
        }

        // move the file to tmp so we can start processing
        $moved_file = $original_file->move($tmp_dir, $filename);

        // Create video data on table
        $video = new Video;
        $video->file_name = $filename;
        $video->run_type = "teamroping";
        $video->processing_complete = false;
        $video->save();

        // Let's queue it up
        $this->dispatch(new \App\Jobs\ProcessVideo($video));
        
        return $video;
    }
}