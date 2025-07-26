<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Models\PostComment;
use App\Services\Post\CommentService;
use App\Http\Requests\Post\CommentRequest;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(CommentRequest $request, Post $post)
    {
        return response()->json($this->commentService->storeComment($post, $request->validated()));
    }

    public function destroy(PostComment $comment)
    {
        return response()->json($this->commentService->destroyComment($comment));
    }

    public function dataComment(Post $post)
    {
        $comments = $this->commentService->getComments($post);
        return response()->json($comments->toArray(request()));
    }
}