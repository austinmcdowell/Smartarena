<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Human;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CreateHumanController extends Controller
{
    public function post(Request $request)
    {        
        $human = new Human;

        $human->type           = $request->input('type');
        $human->classification = $request->input('classification');
        $human->first_name     = $request->input('firstName');
        $human->last_name      = $request->input('lastName');
        $human->location       = $request->input('location');
        $human->email          = $request->input('email');
        $human->phone          = $request->input('phone');

        $human->save();
    
        return ['success' => true];
    }
}