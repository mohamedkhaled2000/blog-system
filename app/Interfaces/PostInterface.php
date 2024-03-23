<?php

namespace App\Interfaces;

use App\Models\Post;

interface PostInterface
{
    public function all($paginate = 10);

    public function find($id);

    public function create(array $data);

    public function update(array $data, Post $post);

    public function delete(Post $post);

    public function forceDelete(Post $post);
}
