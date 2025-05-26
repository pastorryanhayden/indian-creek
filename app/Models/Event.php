<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    /**
     * Get the speakers associated with the camp week.
     */
    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'event_speaker', 'event_id', 'speaker_id');
    }
}
