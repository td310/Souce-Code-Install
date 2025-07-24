<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Services\Post\LikeService;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
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