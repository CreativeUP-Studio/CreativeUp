<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    private const CACHE_TTL = 3600; // 1 hora
    private const SERVICES_LIMIT = 4;
    private const PROJECTS_LIMIT = 4;
    private const POSTS_LIMIT = 4;

    public function index()
    {
        // Cache de toda la página por 1 hora para mejor rendimiento
        $data = Cache::remember('home_page_data', self::CACHE_TTL, function () {
            return [
                'services' => $this->getServices(),
                'featuredProject' => $this->getFeaturedProject(),
                'projects' => $this->getProjects(),
                'posts' => $this->getPosts(),
            ];
        });

        return view('front.home', $data);
    }

    private function getServices()
    {
        return Service::select(['id', 'title', 'slug', 'short_description', 'icon', 'image', 'color'])
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->limit(self::SERVICES_LIMIT)
            ->get();
    }

    private function getFeaturedProject()
    {
        return Project::select(['id', 'title', 'slug', 'description', 'thumbnail', 'type', 'client', 'year', 'published_at'])
            ->where('status', 'published')
            ->with(['images' => function ($query) {
                $query->select(['id', 'project_id', 'image_path'])
                    ->orderBy('id', 'asc')
                    ->limit(2);
            }])
            ->latest('published_at')
            ->first();
    }

    private function getProjects()
    {
        $featuredProject = $this->getFeaturedProject();
        
        return Project::select(['id', 'title', 'slug', 'description', 'thumbnail', 'type', 'client', 'year', 'published_at'])
            ->where('status', 'published')
            ->with(['images' => function ($query) {
                $query->select(['id', 'project_id', 'image_path'])
                    ->orderBy('id', 'asc')
                    ->limit(2);
            }])
            ->when($featuredProject, fn($q) => $q->where('id', '!=', $featuredProject->id))
            ->latest('published_at')
            ->limit(self::PROJECTS_LIMIT)
            ->get();
    }

    private function getPosts()
    {
        return Post::select(['id', 'user_id', 'title', 'slug', 'content', 'featured_image', 'published_at'])
            ->where('status', 'published')
            ->with(['user:id,name,email'])
            ->latest('published_at')
            ->limit(self::POSTS_LIMIT)
            ->get();
    }
}