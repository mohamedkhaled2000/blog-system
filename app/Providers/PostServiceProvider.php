<?php

namespace App\Providers;

use App\Interfaces\CommentInterface;
use App\Interfaces\PostInterface;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            PostInterface::class,
            PostRepository::class
        );

        $this->app->bind(
            CommentInterface::class,
            CommentRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
