<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
    function user()
    {
        $this->belongsTo('App\User');
    }
}