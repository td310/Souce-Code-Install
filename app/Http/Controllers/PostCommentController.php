<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use App\Services\PostCommentService;
use Illuminate\Http\Request;
use App\Http\Requests\PostCommentRequest;

class PostCommentController extends Controller
{
    protected $commentService;

    public function __construct(PostCommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(PostCommentRequest $request, Post $post)
    {
        return response()->json($this->commentService->storeComment($post, $request->validated()));
    }

    public function destroy(PostComment $comment)
    {
        return response()->json($this->commentService->destroyComment($comment));
    }
}