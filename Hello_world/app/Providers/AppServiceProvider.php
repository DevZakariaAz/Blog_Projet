<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\pkgBlog\PkgBlogServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(PkgBlogServiceProvider::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
