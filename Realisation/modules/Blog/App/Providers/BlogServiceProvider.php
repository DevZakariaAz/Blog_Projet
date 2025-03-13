<?php

namespace Modules\Blog\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Charger les routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        // Charger les migrations
        $this->loadMigrationsFrom(__DIR__.'../../Database/migrations');

        // Charger les vues
        $this->loadViewsFrom(__DIR__.'../../Resources/views', 'Blog');

        // Publier les assets si nécessaire
        $this->publishes([
            __DIR__.'../../Resources/views' => resource_path('views/vendor/Blog'),
        ], 'Blog-views');
    }

    public function register()
    {
        // Enregistrer d'autres services si nécessaire
    }
}
