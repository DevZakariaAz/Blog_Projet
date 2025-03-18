<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Blog\Models\Article;
use Modules\Blog\App\Policies\ArticlePolicy;
use Modules\Blog\App\Providers\BlogServiceProvider;
use PhpParser\Node\Expr\AssignOp\Mod;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Article::class => ArticlePolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->register(BlogServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
