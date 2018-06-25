<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    protected $casts = [
        'stats' => 'array'
    ];
    
    public function event()
    {
        return $this->belongsTo('\App\Event');
    }

    public function humans()
    {
        return $this->belongsToMany('\App\Human');
    }

    public function videos()
    {
        return $this->hasMany('\App\Video', 'run_id');
    }
}
