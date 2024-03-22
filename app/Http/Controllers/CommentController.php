<?php

namespace App\Http\Controllers;

use App\Interfaces\CommentInterface;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(
        protected CommentInterface $commentInterface
    )
    {}

    public function store(Request $request, Post $post) {

        // dd($request->content);
        $validated = $request->validate([
            'content' => 'required|array',
            'content.*' => 'required|string'
        ]);

        $comment = $this->commentInterface->create([
            'content' => $validated['content'][$post->id],
        ], $post);

        return back();
    }
}
