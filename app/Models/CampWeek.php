<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampWeek extends Model
{
    protected $guarded = [];

    public $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the speakers associated with the camp week.
     */
    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'camp_week_speaker', 'camp_week_id', 'speaker_id');
    }
    public function type()
    {
        return $this->belongsTo(CampType::class);
    }
}
