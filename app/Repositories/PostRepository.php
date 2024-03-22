<?php

namespace App\Repositories;

use App\Models\Post;
use App\Interfaces\PostInterface;
use Illuminate\Support\Arr;

class PostRepository implements PostInterface {
    public function all($paginate = 10) {
        return Post::isPublished()->latest()->paginate($paginate);
    }

    public function find($id) {
        return Post::findOrFail($id);
    }

    public function create(array $data) {
        $image = Arr::pull($data, 'image');

        $data['user_id'] = auth()->id();
        $post = Post::create($data);

        if ($image) {
            $post->addMedia($image)->toMediaCollection('post_image');
        }

        return $post;
    }

    public function update(array $data, Post $post) {
        return $post->update($data);
    }

    public function delete(Post $post) {
        return $post->delete();
    }
}
