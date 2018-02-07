<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Event;
use App\TeamropingRun;
use App\Human;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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
        $didSucceed = true;

        DB::beginTransaction();

        foreach ($input as $runData) {
            $run = new TeamropingRun;

            $run->date = $runData['date'];
            $run->event_id = $runData['eventId']; 

            if ($runData['headerSaid']) {
                try {
                    $human = Human::where('import_id', $runData['headerSaid'])->firstOrFail();
                    $run->header_human_id = $human->id;
                } catch (ModelNotFoundException $e) {
                    report($e);

                    $didSucceed = false;
                    DB::rollback();
                    break;
                }    
            }

            $run->header_did_catch = $runData['headerCatch'];
            if ($runData['headerCatchType']) {
                $run->header_catch_type = $runData['headerCatchType'];
            } else {
                $run->header_catch_type = null;
            }
            $run->header_penalty_time = $runData['headerPenaltyTime'];

            if ($runData['heelerSaid']) {
                try {
                    $human = Human::where('import_id', $runData['heelerSaid'])->firstOrFail();
                    $run->heeler_human_id = $human->id;
                } catch (ModelNotFoundException $e) {
                    report($e);
   
                    $didSucceed = false;
                    DB::rollback();
                    break;
                }
            }

            $run->heeler_did_catch = $runData['heelerCatch'];

            if ($runData['heelerCatchType']) {
                $run->heeler_catch_type = $runData['heelerCatchType'];
            } else {
                $run->heeler_catch_type = null;
            }
            
            $run->heeler_penalty_time = $runData['heelerPenaltyTime'];

            $run->raw_time = $runData['rawTime'];
            $run->total_time = ($run->raw_time - $run->header_penalty_time - $run->heeler_penalty_time);
            
            try {
                $run->save();
            } catch (QueryException $e) {
                report($e);

                $didSucceed = false;
                DB::rollback();
                break;
            }
        }

        if ($didSucceed) {
            DB::commit();
        }

        return ['success' => $didSucceed];
    }
}