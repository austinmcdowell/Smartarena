<?php

namespace App\Http\Controllers;

use App\Human;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = $request->query('query');

        if (empty($q)) {
            return [];
        }

        $qstr = '%' . strtolower($q) . '%';

        $results = Human::select('id', 'first_name', 'last_name', 'location')
            ->where(DB::raw("first_name || ' ' || last_name"), 'ilike', $qstr)->limit(10)->get();
        
        return $results;
    }
}
