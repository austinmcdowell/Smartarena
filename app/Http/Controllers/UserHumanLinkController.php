<?php

namespace App\Http\Controllers;

use App\Human;
use App\User;

use Illuminate\Http\Request;

class UserHumanLinkController extends Controller
{
    public function get()
    {
        $users = User::orderBy('name')->get();
        $humans = Human::orderBy('first_name')->get();

        return [
          'users' => $users,
          'humans' => $humans
        ];
    }

    public function post(Request $request) {
        $human_id = (int)$request->input('humanId');
        $user_id  = (int)$request->input('userId');

        $human = Human::find($human_id);
        $human->user_id = $user_id;

        $human->save();
        return ['success' => true];
    }
}
