<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Human;

class HumanController extends Controller
{
    public function get()
    {
        return Human::orderBy('first_name')->get();
    }

    public function save(Request $request)
    {
        $id = (int)$request->json('id');
        $classification = $request->json('classification');
        $type = $request->json('type');
        $first_name = $request->json('first_name');
        $last_name = $request->json('last_name');
        $location = $request->json('location');
        $email = $request->json('email');
        $phone = $request->json('phone');
        $calendly_link = $request->json('calendly_link');

        $human = Human::findOrFail($id);
        $human->classification = $classification;
        $human->type = $type;
        $human->first_name = $first_name;
        $human->last_name = $last_name;
        $human->location = $location;
        $human->email = $email;
        $human->phone = $phone;
        $human->calendly_link = $calendly_link;

        $human->save();
        return $human;
    }
}