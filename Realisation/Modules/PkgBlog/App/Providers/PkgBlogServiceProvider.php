<?php

namespace Modules\PkgBlog\App\Providers;

use Illuminate\Support\ServiceProvider;

class PkgBlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load migrations, views, translations, etc.
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../../Resources/Views', 'PkgBlog');
        $this->loadTranslationsFrom(__DIR__ . '/../../Resources/Lang', 'PkgBlog');

        // Load routes from module
        $this->loadRoutesFrom(__DIR__ . '/../../Routes/web.php');
    }

    public function register()
    {
        // Register any services or bindings here.
    }
}
