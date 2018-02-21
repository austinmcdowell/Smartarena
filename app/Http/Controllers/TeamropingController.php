<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Human;
use App\TeamropingRun;
use App\Event;
use App\TeamropingRun;

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

    public function create(Request $request)
    {
        $run = new TeamropingRun;
    
        $run->date = $request->input('date');
        $run->event_id = $request->input('eventId');
        // total time
        //$run->header_did_catch = 
    }

}