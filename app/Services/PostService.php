<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\PostStatus;
use Carbon\Carbon;

class PostService
{
    public function createPost(array $data)
    {
        DB::beginTransaction();
        try {
            $data['user_id'] = Auth::id();

            //Post::flushEventListeners();
            // $post = new Post($data);
            // $post->saveQuietly();
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
            // $post->fill($data);
            // $post->saveQuietly();
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

        if ($request->has('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where('title', 'like', "%{$searchValue}%");
        }

        $query->orderBy('publish_date', 'desc');

        $length = $request->input('length', 5);
        $start = ($request->input('start', 0) / $length) + 1;

        $posts = $query->paginate($length, ['*'], 'page', $start);

        $data = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'thumbnail' => $post->thumbnail,
                'title' => $post->title,
                'description' => Str::limit($post->description, 50, '...'),
                'publish_date' => $post->publish_date,
                'status' => $post->status_label,
            ];
        });

        return [
            'draw' => $request->input('draw'),
            'recordsTotal' => $posts->total(),
            'recordsFiltered' => $posts->total(),
            'data' => $data
        ];
    }

    public function getPublishedPosts()
    {
        return Post::where('status', PostStatus::APPROVE)
            ->where('publish_date', '<=', Carbon::now())
            ->latest('publish_date')
            ->paginate(5);
    }
}
