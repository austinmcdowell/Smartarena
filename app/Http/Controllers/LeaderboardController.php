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
        
        return view('leaderboard', [
            'isLoggedIn' => $isLoggedIn,
            'user' => $user,
            'humans' => $humans
        ]);
    }
}