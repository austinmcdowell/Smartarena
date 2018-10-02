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

    public function processed_videos()
    {
        return $this->hasMany('\App\Video', 'run_id')->where('processing_complete', true);
    }

    public function attach_humans($human_ids)
    {
        $currently_attached_human_ids = $this->humans->map(function($human) {
            return $human->id;
        });

        foreach($currently_attached_human_ids as $human_id) {
            // if not in human_ids from attached, detach
            if (!in_array($human_id, $human_ids)) {
                $this->humans()->detach($human_id);
            }
        }

        foreach($human_ids as $human_id) {
            // if human is already attached, skip
            if ($currently_attached_human_ids->contains($human_id)) {
                continue;
            }

            // if not, let's attach!
            $human = Human::find($human_id);
            if ($human) {
                $this->humans()->attach($human->id);
            }
        }

        return true;
    }
}
