<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostLikeService
{
    public function storeLike(Post $post)
    {
        DB::beginTransaction();
        try {
            $post->likes()->create([
                'user_id' => Auth::id(),
            ]);
            DB::commit();
            return [
                'is_liked' => true,
                'like_count' => $post->likes()->count()
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Like creation failed: ' . $e->getMessage());
        }
    }

    public function destroyLike(Post $post)
    {
        DB::beginTransaction();
        try {
            $like = $post->likes()->where('user_id', Auth::id())->first();
            if ($like) {
                $like->delete();
                DB::commit();
                return [
                    'is_liked' => false,
                    'like_count' => $post->likes()->count(),
                ];
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Like deletion failed: ' . $e->getMessage());
        }
    }
}
