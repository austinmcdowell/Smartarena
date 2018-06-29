<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Human;

class LeaderboardController extends Controller
{
    public function teamroping()
    {   
        $humans = Human::orderBy('last_name')->get();
        $coaches = Human::orderBy('first_name')->where('type', 'pro')->get();
        
        return [
            'humans' => $humans,
            'coaches' => $coaches
        ];
    }
}