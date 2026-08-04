<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;

class AboutController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->take(6)
            ->get(['title', 'slug', 'short_description', 'description', 'icon', 'image', 'color']);

        $projectsCount = Project::where('status', 'published')->count();

        return view('front.about', compact('services', 'projectsCount'));
    }
}
