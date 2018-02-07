<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamropingRun extends Model
{
    public function event()
    {
        return $this->belongsTo('\App\Event');
    }

    public function header()
    {
        return $this->belongsTo('\App\User', 'header_user_id');
    }

    public function heeler()
    {
        return $this->belongsTo('\App\User', 'heeler_user_id');
    }
}
