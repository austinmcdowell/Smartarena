<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Human;
use App\TeamropingRun;
use App\Video;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function get($id)
    {
        $human       = Human::find($id);
        $uploaded_videos = Video::orderBy('created_at')->where('human_id', $id)->whereNull('run_id')->get();
        $header_runs = TeamropingRun::where('header_human_id', $id)->with('videos')->get();
        $heeler_runs = TeamropingRun::where('heeler_human_id', $id)->with('videos')->get();
        return [
            'human'       => $human,
            'headerRuns' => $header_runs,
            'heelerRuns' => $heeler_runs,
            'uploadedVideos' => $uploaded_videos
        ];
    }
}