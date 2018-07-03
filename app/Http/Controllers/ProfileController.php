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
        $uploaded_videos = Video::orderBy('created_at')->where('human_id', $id)->whereNull('run_id')->get();
        $header_runs = Run::where('stats->header->human_id', $id)->with('event', 'videos')->get();
        $heeler_runs = Run::where('stats->heeler->human_id', $id)->with('event', 'videos')->get();
        return [
            'human'       => $human,
            'headerRuns' => $header_runs,
            'heelerRuns' => $heeler_runs,
            'uploadedVideos' => $uploaded_videos
        ];
    }
}