<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
    function user()
    {
        return $this->belongsTo('App\User');
    }

    public function teamropingHeaderRuns()
    {
        return $this->hasMany('App\TeamropingRun', 'header_human_id');
    }

    public function teamropingHeelerRuns()
    {
        return $this->hasMany('App\TeamropingRun', 'heeler_human_id');
    }
}