<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostService
{
    public function createPost(array $data)
    {
        DB::beginTransaction();
        try {
            Log::info('data service: ', $data);
            $data['user_id'] = Auth::id();

            $post = Post::create($data);

            if (!empty($data['file'])) {
                $post->addMedia($data['file'])->toMediaCollection('thumbnail');
            }

            DB::commit();
            return $post;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Post creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updatePost(Post $post, array $data)
    {
        DB::beginTransaction();
        try {
            $post->update($data);

            if (!empty($data['file'])) {
                $post->clearMediaCollection('thumbnail');
                $post->addMedia($data['file'])->toMediaCollection('thumbnail');
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Post update failed: ' . $e->getMessage());
            return false;
        }
    }

    public function deletePost(Post $post)
    {
        DB::beginTransaction();
        try {
            $post->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Post deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteAllPosts()
    {
        DB::beginTransaction();
        try {
            Auth::user()->posts->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk post deletion failed: ' . $e->getMessage());
            return false;
        }
    }
}
