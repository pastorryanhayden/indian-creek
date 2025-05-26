<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class CampType extends Model
{
    protected $guarded = [];

    public function weeks()
    {
        return $this->hasMany(CampWeek::class);
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
