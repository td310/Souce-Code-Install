<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\PostStatus;
use App\Jobs\SendPostStatusJob;

class AdminPostService
{
    public function adminCreatePost(array $data)
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

    public function adminUpdatePost(Post $post, array $data)
    {
        DB::beginTransaction();
        try {
            $originalStatus = $post->status;
            $post->update($data);

            if (!empty($data['file'])) {
                $post->clearMediaCollection('thumbnail');
                $post->addMedia($data['file'])->toMediaCollection('thumbnail');
            }

            if ($data['status'] != $originalStatus->value) {
                $newStatus = PostStatus::from($data['status']);
                SendPostStatusJob::dispatch($post, $newStatus);
            }

            DB::commit();
            return $post;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Post update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function adminDeletePost(Post $post)
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

    public function adminDeleteAllPosts()
    {
        DB::beginTransaction();
        try {
            Post::query()->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk post deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getAdminPostData(Request $request)
    {
        $query = Post::with(['user', 'media']);

        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', "%{$searchValue}%")
                    ->orWhereHas('user', function ($q) use ($searchValue) {
                        $q->where('email', 'like', "%{$searchValue}%");
                    });
            });
        }

        $query->orderBy('publish_date', 'desc');

        $length = $request->input('length', 5);
        $start = ($request->input('start', 0) / $length) + 1;

        $posts = $query->paginate($length, ['*'], 'page', $start);

        $data = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'email' => $post->user->email,
                'thumbnail' => $post->thumbnail,
                'title' => Str::limit($post->title, 50, '...'),
                'description' => Str::limit($post->description, 50, '...'),
                'publish_date' => $post->publish_date,
                'status_label' => $post->status_label,
            ];
        });

        return [
            'draw' => $request->input('draw'),
            'recordsTotal' => $posts->total(),
            'recordsFiltered' => $posts->total(),
            'data' => $data
        ];
    }
}
