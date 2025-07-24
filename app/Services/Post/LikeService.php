<?php

namespace App\Services\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeService
{
    public function storeLike(Post $post)
    {
        try {
            $post->likes()->create([
                'user_id' => Auth::id(),
            ]);
            return [
                'is_liked' => true,
                'like_count' => $post->likes()->count()
            ];
        } catch (\Exception $e) {
            Log::error('Like creation failed: ' . $e->getMessage());
        }
    }

    public function destroyLike(Post $post)
    {
        try {
            $like = $post->likes()->where('user_id', Auth::id())->first();
            if ($like) {
                $like->delete();
                return [
                    'is_liked' => false,
                    'like_count' => $post->likes()->count(),
                ];
            }
        } catch (\Exception $e) {
            Log::error('Like deletion failed: ' . $e->getMessage());
        }
    }
}
