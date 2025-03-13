<?php

namespace Modules\pkgBlog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PkgBlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Charger les routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Charger les migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Charger les vues
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'pkgBlog');

        // Publier les assets si nécessaire
        $this->publishes([
            __DIR__.'/Resources/views' => resource_path('views/vendor/pkgBlog'),
        ], 'pkgBlog-views');
    }

    public function register()
    {
        // Enregistrer d'autres services si nécessaire
    }
}
