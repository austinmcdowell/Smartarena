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

class RunController extends Controller
{
    public function new($video_id)
    {
        $user = Auth::user();
        $events = Event::all();
        $humans = Human::orderBy('first_name')->get();
        $video  = Video::find($video_id);
        return view('runeditor', [
            'events' => $events,
            'humans' => $humans,
            'videos' => [$video],
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
        $video_id = $request->input('videoId');
        $video = Video::find($video_id);

        if (!$video) {
            return response()->json(['success' => false, 'message' => 'Something went wrong, please contact support.'], 401);
        }
        
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
            $catch_type = $request->input('header.catchType');

            if ($catch_type == "missed") {
                $run->header_did_catch = false;
                $run->header_catch_type = null;
                $run->header_penalty_type = $catch_type;
            } else {
                $run->header_did_catch = true;
                $run->header_penalty_type = null;
                $run->header_catch_type = $catch_type;
            }
        }

        if ($request->input('heeler.catchType')) {
            $catch_type = $request->input('heeler.catchType');

            if ($catch_type == 'leg' || $catch_type == 'missed') {
                $run->heeler_did_catch = false;
                $run->heeler_catch_type = null;
                $run->heeler_penalty_type = $catch_type;
            } else {
                $run->heeler_did_catch = true;
                $run->heeler_penalty_type = null;
                $run->heeler_catch_type = $catch_type;
            }
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
            $video->run_id = $run->id;
            $video->save();
        } catch (\Exception $e) {
            DB::rollback();
        }
        
        DB::commit();
       
        return $run;
    }

}