<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostLikeService;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    protected $likeService;

    public function __construct(PostLikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function store(Post $post)
    {
        return response()->json($this->likeService->storeLike($post));
    }
    
    public function destroy(Post $post)
    {
        return response()->json($this->likeService->destroyLike($post));
    }
}