<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Event;

class EventController extends Controller
{
    public function get()
    {
        return Event::all();
    }
}