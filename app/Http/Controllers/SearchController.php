<?php

namespace App\Http\Controllers;

use App\Human;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = $request->query('query');
        $qstr = '%' . strtolower($q) . '%';
        
        $results = Human::where(function($query) use ($qstr) {
            $query->where('first_name', 'ilike', $qstr)
                ->orWhere('last_name', 'ilike', $qstr);
        })->select('id', 'first_name', 'last_name', 'location')->get();

        return $results;
    }
}
