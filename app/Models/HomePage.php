<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'show_video' => 'boolean',
        'show_directions_section' => 'boolean',
        'map_distances' => 'array',
    ];
}
