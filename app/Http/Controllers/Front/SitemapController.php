<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Post;
use App\Models\JobOffer;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $services = Service::where('is_active', true)->latest()->get();
        $projects = Project::where('status', 'published')->latest()->get();
        $posts    = Post::where('status', 'published')->latest()->get();

        $content = view('front.sitemap', compact('services', 'projects', 'posts'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
