<?php

namespace App\Repositories;

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
        return Comment::create($data);
    }

    public function update(array $data, Comment $comment) {
        return $comment->update($data);
    }

    public function delete(Comment $comment) {
        return $comment->delete();
    }
}
