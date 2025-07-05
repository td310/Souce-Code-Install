<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PostService
{
    public function createPost(array $data)
    {
        DB::beginTransaction();
        try {
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
            Auth::user()->posts()->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk post deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getDataTableData(Request $request)
    {
        $query = Post::with(['user', 'media'])
            ->where('user_id', Auth::id());
    
        $start = $request->input('start', 0);
        $length = $request->input('length', 5);
        
        $total = $query->count();
        
        $posts = $query->skip($start)
                      ->take($length)
                      ->get()   
                      ->map(function ($post) {
            return [
                'id' => $post->id,
                'thumbnail' => $post->thumbnail,
                'title' => $post->title,
                'description' => $post->description,
                'publish_date' => $post->publish_date,
                'status_label' => $post->status_label,
            ];
        });
    
        return [
            'draw' => $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $posts
        ];
    }
}
