<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Event;
use App\TeamropingRun;
use Illuminate\Http\Request;

class MassRunUploader extends Controller
{
    /**
     * Mass Run Uploader
     *
     * @return Response
     */
    public function get()
    {
        $events = Event::all();
        return view('massrunuploader', [
          'events' => $events
        ]);
    }

    public function process(Request $request)
    {
        $input = json_decode($request->getContent(), true);

        foreach ($input as $runData) {
          $run = new TeamropingRun;

          $run->date = $runData->date;
          $run->event_id = $runData->eventId;
          // Come back to $run->total_time
          $run->header_did_catch = $runData->headerCatch;
          $run->header_catch_type = $runData->headerCatchType;
          $run->header_penalty_time = $runData->headerPenaltyTime;
          $run->header_user_id = $runData->headerUserId;

          $run->heeler_did_catch = $runData->heelerCatch;
          $run->heeler_catch_type = $runData->heelerCatchType;
          $run->heeler_penalty_time = $runData->heelerPenaltyTime;
          $run->heeler_user_id = $runData->heelerUserId;

          $run->raw_time = $runData->rawTime;

          $run->save();
        }

        // Catch errors, return the proper message along with status code
        // Tomorrow make some columns nullable, also change some of the json
        // node names to be more accurate. Also, change the import data to support
        // user unique IDs
    }
}