<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Interfaces\PostInterface;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function __construct(
        protected PostInterface $postInterface
    )
    {}

    public function create() {
        return Inertia::render('Post/Create');
    }

    public function store(PostRequest $postRequest) {
        $this->postInterface->create($postRequest->validated());
        return redirect()->route('dashboard');
    }

    public function show(Post $post) {
        $post = $this->postInterface->find($post->id);

        if (request()->wantsJson()) {
            return PostResource::make($post);
        }

        return Inertia::render('Post/Show', [
            'post' => PostResource::make($post),
        ]);
    }

    public function edit(Post $post) {
        return Inertia::render('Post/Edit', [
            'post' => PostResource::make($post),
        ]);
    }

    public function update(PostRequest $postRequest, Post $post) {
        $this->postInterface->update($postRequest->validated(), $post);
        return redirect()->route('dashboard');
    }

    public function destroy(Post $post) {
        $this->postInterface->delete($post);
        return back();
    }
}
