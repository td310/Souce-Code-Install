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
            $data['slug'] = Str::slug($data['slug']);

            $originalSlug = $data['slug'];
            $count = 1;
            while (Post::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $count++;
            }

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
            $data['slug'] = Str::slug($data['title']);
            
            $originalSlug = $data['slug'];
            $count = 1;
            while (Post::where('slug', $data['slug'])->where('id', '!=', $post->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $count++;
            }

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
            Post::where('user_id', Auth::id())->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk post deletion failed: ' . $e->getMessage());
            return false;
        }
    }
}
