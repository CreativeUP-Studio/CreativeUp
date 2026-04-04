<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Service;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Compartir configuración del sitio con todas las vistas
        View::composer('*', function ($view) {
            $view->with('siteName', config('app.name', 'CreativeUp'));
        });

        // Compartir servicios con el menú
        View::composer('layouts.app', function ($view) {
            $services = cache()->remember('menu_services', 3600, function () {
                return Service::select(['slug', 'title'])
                    ->where('is_active', true)
                    ->orderBy('order', 'asc')
                    ->get();
            });
            
            $view->with('menuServices', $services);
        });
    }
}
