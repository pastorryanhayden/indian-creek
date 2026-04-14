<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function image(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $path = $request->file('image')->store('editor-images', 'public');

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    public function file(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip|max:10240',
        ]);

        $uploaded = $request->file('file');
        $originalName = $uploaded->getClientOriginalName();

        $path = $uploaded->store('editor-files', ['disk' => 's3', 'visibility' => 'public']);

        return response()->json([
            'url' => Storage::disk('s3')->url($path),
            'name' => $originalName,
        ]);
    }
}
