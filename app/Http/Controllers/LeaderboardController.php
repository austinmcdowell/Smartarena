<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboard
     *
     * @return Response
     */
    public function __invoke()
    {   
        $isLoggedIn = Auth::check();
        return view('leaderboard', ['isLoggedIn' => $isLoggedIn]);
    }
}