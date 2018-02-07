<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
    function user()
    {
        return $this->belongsTo('App\User');
    }
}