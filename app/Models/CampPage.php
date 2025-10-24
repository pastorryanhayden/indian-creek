<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampPage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'step_3_faq' => 'array',
        'step_3_info_text' => 'array',
        'step_4_faq' => 'array',
        'step_5_content' => 'array',
        'step_5_sections' => 'array',
    ];
}
