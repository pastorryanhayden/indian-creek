<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SpeakerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'bio' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'camp_weeks' => 'nullable|array',
            'camp_weeks.*' => 'exists:camp_weeks,id',
            'events' => 'nullable|array',
            'events.*' => 'exists:events,id',
        ];
    }
}
