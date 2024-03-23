<?php

namespace App\Http\Controllers;

use App\Interfaces\CommentInterface;
use App\Interfaces\PostInterface;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function __construct(
        protected CommentInterface $commentInterface,
        protected PostInterface $postInterface
    )
    {}

    public function store(Request $request, Post $post) {
        $validated = $request->validate([
            'content' => 'required|array',
            'content.*' => 'required|string'
        ]);

        $this->commentInterface->create([
            'content' => $validated['content'][$post->id],
        ], $post);

        return back();
    }

    public function destroy(Request $request) {
        $this->commentInterface->delete($request->comments);

        return redirect()->route('dashboard');
    }
}
