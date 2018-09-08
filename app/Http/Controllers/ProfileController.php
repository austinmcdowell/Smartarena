<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Human;
use App\Run;
use App\Video;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function get($id)
    {
        $human       = Human::find($id);
        $associated_videos = Video::orderBy('created_at')->where('human_id', $id)->whereNotNull('run_id')->get();
        $uploaded_videos = Video::orderBy('created_at')->where('human_id', $id)->whereNull('run_id')->get();
        $header_runs = Run::where('stats->header->human_id', $id)->with('event', 'videos')->get();
        $heeler_runs = Run::where('stats->heeler->human_id', $id)->with('event', 'videos')->get();
        return [
            'human'       => $human,
            'headerRuns' => $header_runs,
            'heelerRuns' => $heeler_runs,
            'associatedVideos' => $associated_videos,
            'uploadedVideos' => $uploaded_videos
        ];
    }

    public function hire($id)
    {
        $human = Human::find($id);

        if ($human->type === "pro" && isset($human->calendly_link)) {
            return redirect($human->calendly_link);
        }

        return abort(401, "This pro doesn't exist!");
    }
}