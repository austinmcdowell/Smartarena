<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function human()
    {
        return $this->belongsTo('\App\Human');
    }

    public function run()
    {
        return $this->belongsTo('\App\Run');
    }
}