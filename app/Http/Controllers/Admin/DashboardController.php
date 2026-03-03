<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services' => Service::count(),
            'projects' => Project::count(),
            'posts' => Post::count(),
            'leads' => Lead::count(),
            'published_projects' => Project::where('status', 'published')->count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'new_leads' => Lead::where('status', 'new')->count(),
        ];

        $recentLeads = Lead::with('service')->latest()->take(5)->get();
        $recentPosts = Post::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentLeads', 'recentPosts'));
    }
}
