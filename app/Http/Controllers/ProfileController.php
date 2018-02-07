<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Human;
use App\TeamropingRun;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function get($id)
    {
        $header_runs = TeamropingRun::where('header_human_id', $id)->get();
        $heeler_runs = TeamropingRun::where('heeler_human_id', $id)->get();

        return view('profile', [
          'header_runs' => $header_runs,
          'heeler_runs' => $heeler_runs
        ]);
    }

}