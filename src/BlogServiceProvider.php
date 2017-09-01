<?php

namespace Helori\LaravelBlog;

use Illuminate\Support\ServiceProvider;


class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/laravel-blog.php', 'laravel-blog'
        );
    }
    
    public function boot()
	{
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        
        $this->publishes([
            __DIR__.'/config/laravel-blog.php' => config_path('laravel-blog.php'),
        ], 'laravel-blog-config');

        $this->publishes([
            __DIR__.'/components' => base_path('resources/assets/js/components/laravel-blog'),
        ], 'laravel-blog-assets');
	}
}
