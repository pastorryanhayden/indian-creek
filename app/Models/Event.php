<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

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
            'is_open' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Open events that have not ended yet.
     */
    public function scopeOpenUpcoming(Builder $query): Builder
    {
        return $query
            ->where('is_open', true)
            ->where('end_date', '>=', Carbon::today());
    }

    /**
     * Events suitable for the home page: open, not ended, and starting within the next three months.
     * Ordered soonest first.
     */
    public function scopeForHomePage(Builder $query): Builder
    {
        return $query
            ->openUpcoming()
            ->where('start_date', '<=', Carbon::today()->addMonths(3))
            ->orderBy('start_date')
            ->orderByDesc('is_featured');
    }

    /**
     * Get the speakers associated with the event.
     */
    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'event_speaker', 'event_id', 'speaker_id');
    }
}
