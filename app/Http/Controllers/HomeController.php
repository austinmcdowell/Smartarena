<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Human;
use App\Video;

class HomeController extends Controller
{
    /**
     * Display the Home page
     *
     * @return Response
     */
    public function __invoke()
    {   
        $user = Auth::user();
        $isLoggedIn = Auth::check();
        $humans = Human::orderBy('first_name')->get();
        $coaches = Human::orderBy('first_name')->where('type', 'pro')->get();
        $teamroping_videos = Video::with('human')->orderBy('created_at', 'desc')->limit(8)->get();

        $most_runs_badge = [];
        $most_efficient_badge = [];
        $shortest_average_time_badge = [];
        $most_videos_uploaded_badge = [];

        $stats = [];

        // At some point we want to take this logic and put it into a job that runs every few minutes

        foreach ($humans as $human) {
            $run_count = 0;
            $catch_count = 0;
            $penalties = 0;
            $total_penalties = 0;
            $total_raw_time = 0;
            $time_with_penalties = 0;
            $catch_percentage = 0;
            $sum_of_average_time = 0;
            $total_videos_count = $human->videos->count();

            // Attach first video
            $human['video'] = $human->first_video;
            
            foreach($human->runs as $run) {
                $run_count++;
                
                $stats = $run->stats;

                $total_raw_time += $stats['raw_time'];
                $penalties_for_run = 0;

                if ($stats['header']['human_id'] === $human->id) {
                    if ($stats['header']['did_catch']) {
                        $catch_count++;
                    }
                    
                    if (isset($stats['header']['penalty_time'])) {
                        $penalties += $stats['header']['penalty_time'];
                        $penalties_for_run += $stats['header']['penalty_time'];
                    }

                    if (isset($stats['heeler']['penalty_time'])) {
                        $penalties_for_run += $stats['heeler']['penalty_time'];
                    }

                    if (isset($stats['header']['barrier_penalty'])) {
                        $penalties += $stats['header']['barrier_penalty'];
                        $penalties_for_run += $stats['header']['barrier_penalty'];
                    }
    
                    if (isset($stats['heeler']['barrier_penalty'])) {
                        $penalties_for_run += $stats['heeler']['barrier_penalty'];
                    }
                }

                if ($stats['heeler']['human_id'] === $human->id) {
                    if ($stats['heeler']['did_catch']) {
                        $catch_count++;
                    }
                    
                    if (isset($stats['heeler']['penalty_time'])) {
                        $penalties += $stats['heeler']['penalty_time'];
                        $penalties_for_run += $stats['heeler']['penalty_time'];
                    }

                    if (isset($stats['header']['penalty_time'])) {
                        $penalties_for_run += $stats['header']['penalty_time'];
                    }

                    if (isset($stats['heeler']['barrier_penalty'])) {
                        $penalties += $stats['heeler']['barrier_penalty'];
                        $penalties_for_run += $stats['heeler']['barrier_penalty'];
                    }
    
                    if (isset($stats['header']['barrier_penalty'])) {
                        $penalties_for_run += $stats['header']['barrier_penalty'];
                    }
                }

                $total_penalties += $penalties_for_run;
                $time_with_penalties = $total_raw_time + $total_penalties;
                $catch_percentage = $catch_count / $run_count;
                $sum_of_average_time = $time_with_penalties / $run_count;
            }

            if ($shortest_average_time_badge) {
                if ($sum_of_average_time < $shortest_average_time_badge['count']) {
                    $shortest_average_time_badge = [
                        'human_id' => $human->id,
                        'human_name' => $human->first_name . ' ' . $human->last_name,
                        'count' => $sum_of_average_time
                    ];
                }
            } else {
                $shortest_average_time_badge = [
                    'human_id' => $human->id,
                    'human_name' => $human->first_name . ' ' . $human->last_name,
                    'count' => $sum_of_average_time
                ];
            }

            if ($most_efficient_badge) {
                if ($penalties < $most_efficient_badge['count']) {
                    $most_efficient_badge = [
                        'human_id' => $human->id,
                        'human_name' => $human->first_name . ' ' . $human->last_name,
                        'count' => $penalties
                    ];
                }
            } else {
                $most_efficient_badge = [
                    'human_id' => $human->id,
                    'human_name' => $human->first_name . ' ' . $human->last_name,
                    'count' => $penalties
                ];
            }

            if ($most_runs_badge) {
                if ($run_count > $most_runs_badge['count']) {
                    $most_runs_badge = [
                        'human_id' => $human->id,
                        'human_name' => $human->first_name . ' ' . $human->last_name,
                        'count' => $run_count
                    ];
                }
            } else {
                $most_runs_badge = [
                    'human_id' => $human->id,
                    'human_name' => $human->first_name . ' ' . $human->last_name,
                    'count' => $run_count
                ];
            }

            if ($most_videos_uploaded_badge) {
                if ($total_videos_count > $most_videos_uploaded_badge['count']) {
                    $most_videos_uploaded_badge = [
                        'human_id' => $human->id,
                        'human_name' => $human->first_name . ' ' . $human->last_name,
                        'count' => $total_videos_count
                    ];
                }
            } else {
                $most_videos_uploaded_badge = [
                    'human_id' => $human->id,
                    'human_name' => $human->first_name . ' ' . $human->last_name,
                    'count' => $total_videos_count
                ];
            }

            $stats[$human->id] = [
                'catch_count' => $catch_count, 
                'run_count' => $run_count,
                'penalties' => $penalties,
                'total_penalties' => $total_penalties,
                'total_raw_time' => $total_raw_time,
                'time_with_penalties' => $time_with_penalties,
                'catch_percentage' => round($catch_percentage * 100, 2),
                'sum_of_average_time' => round($sum_of_average_time, 2)   
            ];
        }
        
        return [
            'humans' => $humans,
            'coaches' => $coaches,
            'stats' => $stats,
            'mostRunsBadge' => $most_runs_badge,
            'mostEfficientBadge' => $most_efficient_badge,
            'shortestAverageTimeBadge' => $shortest_average_time_badge,
            'mostVideosUploadedBadge' => $most_videos_uploaded_badge,
            'teamropingVideos' => $teamroping_videos
        ];
    }
}