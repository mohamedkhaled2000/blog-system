<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Interfaces\PostInterface;
use Inertia\Inertia;

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

}
