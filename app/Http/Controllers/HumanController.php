<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Human;

class HumanController extends Controller
{
    public function get()
    {
        return Human::orderBy('first_name')->get();
    }
}