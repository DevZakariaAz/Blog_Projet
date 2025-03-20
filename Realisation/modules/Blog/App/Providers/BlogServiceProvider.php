<?php

namespace Modules\Blog\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Blog\Models\Category;
use Modules\Blog\App\Policies\CategoryPolicy;
use Modules\Blog\Models\Article;
use Modules\Blog\App\Policies\ArticlePolicy;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Charger les routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        // Charger les migrations
        $this->loadMigrationsFrom(__DIR__.'/../../Database/migrations');

        // Charger les vues
        $this->loadViewsFrom(__DIR__.'/../../Resources/views', 'Blog');

        // Publier les assets si nécessaire
        $this->publishes([
            __DIR__.'../../Resources/views' => resource_path('views/vendor/Blog'),
        ], 'Blog-views');

        // Register the policy for Category model
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Article::class, ArticlePolicy::class);

    }

    public function register()
    {
        // Enregistrer d'autres services si nécessaire
    }
}
