<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamropingRun extends Model
{
    function event()
    {
        $this->belongsTo('App\Event');
    }

    function header()
    {
        $this->belongsTo('App\User', 'header_user_id');
    }

    function heeler()
    {
        $this->belongsTo('App\User', 'heeler_user_id');
    }
}
