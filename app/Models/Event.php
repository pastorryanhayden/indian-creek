<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Get the speakers associated with the camp week.
     */
    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'event_speaker', 'event_id', 'speaker_id');
    }
}
