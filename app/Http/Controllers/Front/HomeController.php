<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Post;
use App\Models\HeroSetting;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    private const CACHE_TTL = 3600; // 1 hora
    private const SERVICES_LIMIT = 6; // Aumentado para Bento Grid
    private const PROJECTS_LIMIT = 5; // Aumentado para Masonry
    private const POSTS_LIMIT = 3; // Ajustado para el nuevo diseño

    public function index()
    {
        // Hero, services y projects se cachean 1 hora (cambian poco)
        $data = Cache::remember('home_page_data', self::CACHE_TTL, function () {
            return [
                'hero'            => HeroSetting::getActive(),
                'services'        => $this->getServices(),
                'featuredProject' => $this->getFeaturedProject(),
                'projects'        => $this->getProjects(),
            ];
        });

        // Posts SIEMPRE frescos — reflejan lo publicado desde admin
        $data['posts'] = $this->getPosts();

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
        return Project::select(['id', 'title', 'slug', 'description', 'thumbnail', 'type', 'client', 'year', 'published_at', 'thumbnail_device', 'url'])
            ->where('status', 'published')
            ->with(['images' => function ($query) {
                $query->select(['id', 'project_id', 'image_path'])
                    ->orderBy('id', 'asc')
                    ->limit(2);
            }])
            ->latest('published_at')
            ->limit(self::PROJECTS_LIMIT)
            ->get();
    }

    private function getPosts()
    {
        return Post::select(['id', 'user_id', 'title', 'slug', 'content', 'featured_image', 'category', 'status', 'published_at'])
            ->where('status', 'published')
            ->with(['user:id,name,email,avatar,position'])
            ->latest('published_at')
            ->limit(self::POSTS_LIMIT)
            ->get();
    }
}