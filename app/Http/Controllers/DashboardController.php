<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Interfaces\PostInterface;
use App\Http\Resources\PostResource;

class DashboardController extends Controller
{
    public function __construct(
        protected PostInterface $postInterface
    )
    {}

    public function __invoke()
    {
        $posts = $this->postInterface->all();

        if (request()->wantsJson()) {
            return PostResource::collection($posts);
        }

        return Inertia::render('Dashboard', [
            'posts'             => PostResource::collection($posts),
        ]);
    }
}
