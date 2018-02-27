<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Human;
use App\TeamropingRun;
use App\Event;

use Illuminate\Http\Request;

class TeamropingController extends Controller
{
    public function new()
    {
        $events = Event::all();
        $humans = Human::all();
        return view('teamroping.new', [
            'events' => $events,
            'humans' => $humans
        ]);
    }

    public function create(Request $request)
    {
        $run = new TeamropingRun;
    
        $run->date = $request->input('date');
        $run->event_id = $request->input('eventId');
        // total time
        //$run->header_did_catch = 
    }

    public function upload(Request $request)
    {
        $original_file = $request->file('video');
        $tmp_dir = sys_get_temp_dir();
        $mime_type = $original_file->getClientMimeType();

        if ($mime_type != "video/mp4") {
            // CHOKE
        }

        // Create video data on table


        // move the file to tmp so we can start processing
        $moved_file = $original_file->move($tmp_dir, $original_file->getOriginalClientName());
        
    }
}