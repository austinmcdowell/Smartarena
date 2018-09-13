<?php

namespace App\Http\Controllers;

use Auth;
use DateTime;

use App\User;
use App\Http\Controllers\Controller;
use App\Event;
use App\Run;
use App\Human;
use App\Video;

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
    public function events()
    {
        $events = Event::all();
        return $events;
    }

    public function process(Request $request)
    {
        $input = json_decode($request->getContent(), true);
        $didSucceed = true;

        DB::beginTransaction();

        foreach ($input as $runData) {
            $run = new Run;

            $header;
            $heeler;
            $run->date = $runData['date'];
            $run->event_id = $runData['eventId'];
            $run->type = 'teamroping';

            $stats = [
                'header' => [],
                'heeler' => []
            ];

            if ($runData['headerSaid']) {
                try {
                    $header = Human::where('import_id', $runData['headerSaid'])->firstOrFail();
                    $stats['header']['human_id'] = $header->id;
                } catch (ModelNotFoundException $e) {
                    report($e);

                    $didSucceed = false;
                    DB::rollback();
                    break;
                }    
            }

            $stats['header']['did_catch'] = $runData['headerCatch'];

            if (!$stats['header']['did_catch']) {
                $stats['no_time'] = true;
            }

            $header_catch_type = $runData['headerCatchType'];
            if ($header_catch_type) {
                if ($header_catch_type == 'missed') {
                    $stats['no_time'] = true;
                    $stats['header']['catch_type'] = null;
                } else {
                    $stats['header']['catch_type'] = $header_catch_type;
                }    
            } else {
                $stats['header']['catch_type'] = null;
            }
            $stats['header']['penalty_time'] = $runData['headerPenaltyTime'];
            
            if ($runData['headerPenaltyType']) {
                if ($runData['headerPenaltyType'] == 'barrier') {
                    $stats['header']['barrier_penalty'] = 5;
                } else if ($runData['headerPenaltyType'] != 'none'){
                    $stats['header']['penalty_type'] = $runData['headerPenaltyType'];
                }
            }

            if ($runData['heelerSaid']) {
                try {
                    $heeler = Human::where('import_id', $runData['heelerSaid'])->firstOrFail();
                    $stats['heeler']['human_id'] = $heeler->id;
                } catch (ModelNotFoundException $e) {
                    report($e);
   
                    $didSucceed = false;
                    DB::rollback();
                    break;
                }
            }

            $stats['heeler']['did_catch'] = $runData['heelerCatch'];

            if (!$stats['heeler']['did_catch']) {
                $stats['no_time'] = true;
            }

            $heeler_catch_type = $runData['heelerCatchType'];

            if ($heeler_catch_type) {
                if ($heeler_catch_type == 'missed') {
                    $stats['no_time'] = true;
                    $stats['heeler']['catch_type'] = null;
                } else {
                    $stats['heeler']['catch_type'] = $heeler_catch_type;
                }
            } else {
                $stats['heeler']['catch_type'] = null;
            }
            
            $stats['heeler']['penalty_time'] = $runData['heelerPenaltyTime'];

            if ($runData['heelerPenaltyType']) {
                if ($runData['heelerPenaltyType'] == 'barrier') {
                    $stats['heeler']['barrier_penalty'] = 5;
                } else if ($runData['heelerPenaltyType'] != 'none') {
                    $stats['heeler']['penalty_type'] = $runData['heelerPenaltyType'];
                }
            }

            $stats['raw_time'] = $runData['rawTime'];
            $stats['total_time'] = ($stats['raw_time'] - $stats['header']['penalty_time'] - $stats['heeler']['penalty_time']);
            
            if ($runData['file']) {
                $video = new Video;
                $video->file_name = $runData['file'];
                $video->processing_complete = false;
            }

            $run->stats = $stats;

            try {
                $run->save();

                if ($header) {
                    $run->humans()->attach($header->id);
                }

                if ($heeler) {
                    $run->humans()->attach($heeler->id);
                }

                $video->run_id = $run->id;
                $video->save();
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

    public function uploadVideo(Request $request)
    {
        $user = Auth::user();
        $run_id = $request->input('runId');
        $original_file = $request->file('video');
        $tmp_dir = sys_get_temp_dir();
        $mime_type = $original_file->getClientMimeType();
        $date = new DateTime;
        $original_filename = $original_file->getClientOriginalName();
        $filename = $user->id . "-" . $date->getTimestamp() . "-" . uniqid();

        // Eventually do MIME type checks

        try {
            $video = Video::where('file_name', $original_filename)
            ->where('processing_complete', false)
            ->where('file_url', null)
            ->where('thumbnail_url', null)->firstOrFail();

            if ($run_id) {
                Video::where('run_id', $video->run_id)->delete();
            }

            // move the file to tmp so we can start processing
            $moved_file = $original_file->move($tmp_dir, $filename);

            $video->file_name = $filename;
            $video->save();

            // Let's queue it up
            $this->dispatch(new \App\Jobs\ProcessVideo($video));
            
            return $video;
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
        
    }
}