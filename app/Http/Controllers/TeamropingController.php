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
use Illuminate\Support\Facades\DB;

class TeamropingController extends Controller
{
    public function new()
    {
        $user = Auth::user();
        $events = Event::all();
        $humans = Human::orderBy('first_name')->get();
        return view('runeditor', [
            'events' => $events,
            'humans' => $humans,
            'videos' => [],
            'human_id' => $user->human->id
        ]);
    }

    public function edit($id)
    {
        $user = Auth::user();
        $events = Event::all();
        $humans = Human::orderBy('first_name')->get();
        $run = TeamropingRun::find($id);
        return view('runeditor', [
            'events' => $events,
            'humans' => $humans,
            'videos' => $run->videos,
            'human_id' => $user->human->id,
            'run' => $run
        ]);
    }

    public function save(Request $request)
    {
        $user = Auth::user();
        $runId = $request->input('runId');
        
        if ($runId) {
            $run = TeamropingRun::find($runId);
        } else {
            $run = new TeamropingRun;
        }
        
        $run->date = $request->input('date');

        $event_id = (int)$request->input('eventId');
        $event = Event::find($event_id);

        if (!$event) {
            abort(401, "This event doesn't exist!");
        }

        $run->event_id = $event->id;
        
        // lets take care of validations first

        $header_human_id = (int)$request->input('header.humanId');
        $heeler_human_id = (int)$request->input('heeler.humanId');
        
        $header = Human::find($header_human_id);
        $run->header_human_id = $header->id;

        $heeler = Human::find($heeler_human_id);
        $run->heeler_human_id = $heeler->id;

        if ($header->user_id != $user->id && $heeler->user_id != $user->id) {
            abort(401, "You must be either the header or the heeler.");
        }

        if ($request->input('header.catchType')) {
            $run->header_did_catch = true;
            $run->header_catch_type = $request->input('header.catchType');
        } else {
            $run->header_did_catch = false;
            $run->header_catch_type = null;
        }

        if ($request->input('header.penaltyType')) {
            $run->header_did_catch = false;
            $run->header_penalty_type = $request->input('header.penaltyType');
        }

        if ($request->input('heeler.catchType')) {
            $run->heeler_did_catch = true;
            $run->heeler_catch_type = $request->input('heeler.catchType');
        } else {
            $run->heeler_did_catch = false;
            $run->heeler_catch_type = null;
        }

        if ($request->input('heeler.penaltyType')) {
            $run->heeler_did_catch = false;
            $run->heeler_penalty_type = $request->input('heeler.penaltyType');
        }

        $run->header_barrier_penalty = (int)$request->input('header.barrierPenalty');
        $run->heeler_barrier_penalty = (int)$request->input('heeler.barrierPenalty');

        $run->roping = $request->input('roping');
        $run->round  = $request->input('round');
        $run->raw_time = (float)$request->input('time');

        // penalty calculations
        if ($run->header_penalty_type == 'missed') {
            $run->no_time = true;
        }

        if ($run->heeler_penalty_type == 'missed') {
            $run->no_time = true;
        }

        if ($run->heeler_penalty_type == 'leg') {
            $run->heeler_penalty_time = 5;
        }

        if (!$run->header_penalty_time) {
            $run->header_penalty_time = 0;
        }

        if (!$run->heeler_penalty_time) {
            $run->heeler_penalty_time = 0;
        }

        $run->total_time = $run->raw_time + $run->heeler_penalty_time + $run->header_penalty_time + $run->header_barrier_penalty + $run->heeler_barrier_penalty;
        
        DB::beginTransaction();

        try {
            $run->save();

            // Video linking
            $video_id = (int)$request->input('currentVideo.id');
            if ($video_id) {
                $video = Video::find($video_id);
                $video->run_id = $run->id;
                $video->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
        }
        
        DB::commit();
       
        return $run;
    }

    public function upload(Request $request)
    {
        $user = Auth::user();
        $run_id = $request->input('runId');
        $original_file = $request->file('video');
        $tmp_dir = sys_get_temp_dir();
        $mime_type = $original_file->getClientMimeType();
        $date = new DateTime;
        $original_filename = $original_file->getClientOriginalName();
        $filename = $user->id . "-" . $date->getTimestamp() . "-". str_replace([' ', '(', ')', '%'], '', $original_filename);
    
        if ($run_id) {
            Video::where('run_id', $run_id)->delete();
        }

        // move the file to tmp so we can start processing
        $moved_file = $original_file->move($tmp_dir, $filename);

        // Create video data on table
        $video = new Video;
        $video->file_name = $filename;
        $video->run_type = "teamroping";
        $video->processing_complete = false;

        if ($run_id) {
            $video->run_id = $run_id;
        }

        $video->save();

        // Let's queue it up
        $this->dispatch(new \App\Jobs\ProcessVideo($video));
        
        return $video;
    }
}