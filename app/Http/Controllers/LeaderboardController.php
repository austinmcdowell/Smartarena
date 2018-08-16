<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Human;
use App\Video;

class LeaderboardController extends Controller
{
    public function videos()
    {   
        $humans = Human::withCount('quality_videos')->orderBy('quality_videos_count', 'desc')->limit(10)->get();
        $coaches = Human::orderBy('first_name')->where('type', 'pro')->get();
        $teamroping_videos = Video::with('human')->limit(8)->get();
        
        return [
            'humans' => $humans,
            'coaches' => $coaches,
            'videos' => $teamroping_videos
        ];
    }
}