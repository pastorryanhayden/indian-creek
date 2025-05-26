<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Speaker extends Model
{
    protected $guarded = [];

    /**
     * Get the camp weeks associated with the speaker.
     */
    public function campWeeks()
    {
        return $this->belongsToMany(CampWeek::class, 'camp_week_speaker', 'speaker_id', 'camp_week_id');
    }

    /**
     * Get the events associated with the speaker.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_speaker', 'speaker_id', 'event_id');
    }

    /**
     * Get the formatted name with line breaks instead of spaces.
     */
    protected function formattedName(): Attribute
    {
        return Attribute::make(
            get: fn () => str_replace(' ', '<br>', $this->name),
        );
    }


}
