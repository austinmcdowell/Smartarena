<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Human;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class MassHumanUploader extends Controller
{
    public function process(Request $request)
    {
        $input = json_decode($request->getContent(), true);
        $didSucceed = true;

        DB::beginTransaction();

        foreach ($input as $humanData) {
            $human = new Human;

            $human->import_id      = $humanData['importId'];
            $human->classification = $humanData['classification'];
            $human->first_name     = trim(ucfirst(strtolower($humanData['firstName'])));
            $human->last_name      = trim(ucfirst(strtolower($humanData['lastName'])));
            $human->location       = trim(ucwords(strtolower($humanData['location'])));
            $human->type           = 'standard';
            try {
                $human->save();
            } catch (QueryException $e) {
                report($e);

                $didSucceed = false;
                DB::rollback();
                break;
            }  
        }

        if ($didSucceed) {
            DB::commit();
        }
        
        return ['success' => $didSucceed];
    }
}