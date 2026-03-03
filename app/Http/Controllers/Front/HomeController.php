<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->take(4)->get();
        $featuredProject = Project::where('status', 'published')->with('images')->latest('published_at')->first();
        $projects = Project::where('status', 'published')
            ->with('images')
            ->when($featuredProject, fn($q) => $q->where('id', '!=', $featuredProject->id))
            ->latest('published_at')
            ->take(4)
            ->get();
        $posts = Post::where('status', 'published')->latest('published_at')->take(4)->get();

        return view('front.home', compact('services', 'featuredProject', 'projects', 'posts'));
    }
}