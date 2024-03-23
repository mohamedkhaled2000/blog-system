<?php

namespace App\Interfaces;

use App\Models\Comment;
use App\Models\Post;

interface CommentInterface
{
    public function find($id);

    public function create(array $data, Post $post);

    public function delete(array $comments);
}
