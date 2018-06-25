<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
    function user()
    {
        return $this->belongsTo('App\User');
    }

    public function runs()
    {
        return $this->belongsToMany('App\Run');
    }

    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    public function getFirstVideoAttribute()
    {
        $video = $this->videos()->first();

        if ($video) {
            return $video;
        }

        $run = $this->runs()->first();
        if ($run) {
            $video = $run->videos()->first();
            if ($video) {
                return $video;
            }
        }
    }
}