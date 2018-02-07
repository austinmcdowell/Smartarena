<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function teamropingRuns() {
        return $this->hasMany('App\TeamropingRun');
    }
}
