<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Human;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CreateHumanController extends Controller
{
    /**
     * Mass Run Uploader
     *
     * @return Response
     */
    public function get()
    {
        return view('createhuman');
    }

    public function post(Request $request)
    {        
        $human = new Human;

        $human->classification = $request->input('classification');
        $human->first_name     = $request->input('firstName');
        $human->last_name      = $request->input('lastName');
        $human->location       = $request->input('location');

        $human->save();
    
        return ['success' => true];
    }
}