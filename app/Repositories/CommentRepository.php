<?php

namespace App\Repositories;

use App\Http\Resources\CommentResource;
use App\Interfaces\CommentInterface;
use App\Models\Comment;
use App\Models\Post;

class CommentRepository implements CommentInterface {

    public function find($id) {
        return Comment::findOrFail($id);
    }

    public function create(array $data, Post $post) {
        $data['user_id'] = auth()->id();
        $data['post_id'] = $post->id;
        $comment = Comment::create($data);

        return CommentResource::make($comment);
    }

    public function delete(array $comments) {
        return Comment::destroy($comments);
    }
}
