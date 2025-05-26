<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
class PageController extends Controller
{
    public function show($slug, Request $request)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('page', compact('page'));
    }

}
