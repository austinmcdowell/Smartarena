<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Human;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboard
     *
     * @return Response
     */
    public function __invoke()
    {   
        $user = Auth::user();
        $isLoggedIn = Auth::check();
        $humans = Human::all();
        $stats = [];

        foreach ($humans as $human) {
            $run_count = 0;
            $catch_count = 0;
            $penalties = 0;
            $total_penalties = 0;
            $total_raw_time = 0;
            $time_with_penalties = 0;
            $catch_percentage = 0;
            $sum_of_average_time = 0;

            foreach ($human->teamropingHeaderRuns as $run) {
                $run_count++;

                if ($run->header_did_catch) {
                    $catch_count++;
                }

                $total_raw_time += $run->raw_time;

                $penalties_for_run = 0;

                if ($run->header_penalty_time) {
                    $penalties += $run->header_penalty_time;
                    $penalties_for_run += $run->header_penalty_time;
                }

                if ($run->heeler_penalty_time) {
                    $penalties_for_run += $run->heeler_penalty_time;
                }

                if ($run->header_barrier_penalty) {
                    $penalties += $run->header_barrier_penalty;
                    $penalties_for_run += $run->header_barrier_penalty;
                }

                if ($run->heeler_barrier_penalty) {
                    $penalties_for_run += $run->heeler_barrier_penalty;
                }

                $total_penalties += $penalties_for_run;
                $time_with_penalties = $total_raw_time + $total_penalties;
                $catch_percentage = $catch_count / $run_count;
                $sum_of_average_time = $time_with_penalties / $run_count;
            }

            foreach ($human->teamropingHeelerRuns as $run) {
                $run_count++;

                if ($run->header_did_catch) {
                    $catch_count++;
                }

                $total_raw_time += $run->raw_time;

                $penalties_for_run = 0;

                if ($run->header_penalty_time) {
                    $penalties_for_run += $run->header_penalty_time;
                }

                if ($run->heeler_penalty_time) {
                    $penalties += $run->heeler_penalty_time;
                    $penalties_for_run += $run->heeler_penalty_time;
                }

                if ($run->header_barrier_penalty) {
                    $penalties_for_run += $run->header_barrier_penalty;
                }

                if ($run->heeler_barrier_penalty) {
                    $penalties += $run->heeler_barrier_penalty;
                    $penalties_for_run += $run->heeler_barrier_penalty;
                }

                $total_penalties += $penalties_for_run;
                $time_with_penalties = $total_raw_time + $total_penalties;
                $catch_percentage = $catch_count / $run_count;
                $sum_of_average_time = $time_with_penalties / $run_count;
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
        
        return view('leaderboard', [
            'isLoggedIn' => $isLoggedIn,
            'user' => $user,
            'humans' => $humans,
            'stats' => $stats
        ]);
    }
}