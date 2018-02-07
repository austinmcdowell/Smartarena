<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Human;
use App\TeamropingRun;
use App\Event;

use Illuminate\Http\Request;

class TeamropingController extends Controller
{
    public function new()
    {
        $events = Event::all();
        $humans = Human::all();
        return view('teamroping.new', [
            'events' => $events,
            'humans' => $humans
        ]);
    }

}