<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SPAController extends Controller
{
    /**
     * Display the leaderboard
     *
     * @return Response
     */
    public function __invoke()
    {   
        $user = Auth::user();
        $user->human;
        return view('app', [
            'user' => $user
        ]);
    }
}