<?php

namespace App\Http\Controllers;

use Auth;
use DateTime;
use App\Http\Controllers\Controller;
use App\Human;
use App\Run;
use App\Event;
use App\Video;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RunController extends Controller
{
    public function get($id)
    {
        $run = Run::find($id);

        if ($run) {
            $run->videos;
        }

        return $run;
    }

    public function save(Request $request)
    {
        $user = Auth::user();
        $run_id = $request->json('id');
        $video_id = $request->json('video_id');
        $video = Video::find($video_id);

        if (!$video) {
            return response()->json(['success' => false, 'message' => 'Something went wrong, please contact support.'], 401);
        }
        
        if ($run_id) {
            $run = Run::find($run_id);
        } else {
            $run = new Run;
            $run->type = "teamroping";
        }
        
        $run->date = $request->json('date');

        $event_id = (int)$request->json('event_id');
        $event = Event::find($event_id);

        if (!$event) {
            abort(401, "This event doesn't exist!");
        }

        $run->event_id = $event->id;
        
        $stats = $request->json('stats');

        $header_human_id = (int)$stats['header']['human_id'];
        $heeler_human_id = (int)$stats['heeler']['human_id'];
        
        if (!$header_human_id || !$heeler_human_id) {
            abort(401, "Header and heeler must be specified.");
        }

        $header = Human::find($header_human_id);
        $heeler = Human::find($heeler_human_id);

        if ($header->user_id != $user->id && $heeler->user_id != $user->id) {
            abort(401, "You must be either the header or the heeler.");
        }

        if ($stats['header']['penalty_type']) {
            $penalty_type = $stats['header']['penalty_type'];

            $stats['header']['did_catch'] = false;
            $stats['header']['catch_type'] = null;
            $stats['header']['penalty_type'] = $penalty_type;

            $stats['heeler']['did_catch'] = false;
            $stats['heeler']['catch_type'] = null;
            $stats['heeler']['penalty_type'] = null;
        }

        if ($stats['header']['catch_type']) {
            $catch_type = $stats['header']['catch_type'];

            $stats['header']['did_catch'] = true;
            $stats['header']['penalty_type'] = null;
            $stats['header']['catch_type'] = $catch_type;
        }

        if ($stats['heeler']['penalty_type']) {
            $penalty_type = $stats['heeler']['penalty_type'];

            $stats['heeler']['did_catch'] = false;
            $stats['heeler']['catch_type'] = null;
            $stats['heeler']['penalty_type'] = $penalty_type;
        }

        if ($stats['heeler']['catch_type']) {
            $catch_type = $stats['heeler']['catch_type'];

            $stats['heeler']['did_catch'] = true;
            $stats['heeler']['penalty_type'] = null;
            $stats['heeler']['catch_type'] = $catch_type;
        }

        $header_barrier_penalty = (int)$stats['header']['barrier_penalty'];
        $heeler_barrier_penalty = (int)$stats['heeler']['barrier_penalty'];

        $roping = $stats['roping'];
        $round  = $stats['round'];
        $raw_time = (float)$stats['time'];

        // penalty calculations
        $header_penalty_time = 0;
        $heeler_penalty_time = 0;
        
        if ($stats['header']['penalty_type'] == 'missed') {
            $no_time = true;
        }

        if ($stats['heeler']['penalty_type'] == 'missed') {
            $no_time = true;
        }

        if ($stats['heeler']['penalty_type'] == 'leg') {
            $heeler_penalty_time = 5;
        }

        $stats['total_time'] = $stats['raw_time'] + $heeler_penalty_time + $header_penalty_time + $header_barrier_penalty + $heeler_barrier_penalty;
        
        $run->stats = $stats;

        DB::beginTransaction();

        try {
            $run->save();

            // Video linking
            $video->run_id = $run->id;
            $video->save();
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
        }
        
        DB::commit();
       
        return $run;
    }

}