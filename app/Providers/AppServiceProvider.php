<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Service;
use App\Models\Project;
use App\Models\Post;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Limpiar caché del home cuando se modifica contenido
        $this->registerCacheClearingEvents();
    }

    /**
     * Register events to clear home page cache
     */
    protected function registerCacheClearingEvents(): void
    {
        // Limpiar caché cuando se modifican servicios
        Service::created(fn() => $this->clearHomeCache());
        Service::updated(fn() => $this->clearHomeCache());
        Service::deleted(fn() => $this->clearHomeCache());

        // Limpiar caché cuando se modifican proyectos
        Project::created(fn() => $this->clearHomeCache());
        Project::updated(fn() => $this->clearHomeCache());
        Project::deleted(fn() => $this->clearHomeCache());

        // Limpiar caché cuando se modifican posts
        Post::created(fn() => $this->clearHomeCache());
        Post::updated(fn() => $this->clearHomeCache());
        Post::deleted(fn() => $this->clearHomeCache());
    }

    /**
     * Clear home page and menu caches
     */
    protected function clearHomeCache(): void
    {
        Cache::forget('home_page_data');
        Cache::forget('menu_services');
    }
}
