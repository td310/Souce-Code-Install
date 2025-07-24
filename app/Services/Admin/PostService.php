<?php

namespace App\Services\Admin;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Enums\PostStatus;
use App\Jobs\SendPostStatusJob;
use App\Http\Resources\Admin\PostResource;

class PostService
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
        try {
            $post->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Post deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    public function adminDeleteAllPosts()
    {
        try {
            Post::query()->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Bulk post deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getAdminPostData(array $data)
    {
        $query = Post::with(['user', 'media'])->select('posts.*');

        $searchText = $data['search_text'] ?? null;
        $searchStatus = isset($data['status']) && $data['status'] !== '' ? (int)$data['status'] : null;

        if (!empty($searchText) || !is_null($searchStatus)) {
            $query->where(function ($q) use ($searchText, $searchStatus) {
                if (!empty($searchText)) {
                    $q->whereAny(['posts.title', 'users.email'], 'like', "%{$searchText}%");
                }
                if (!is_null($searchStatus)) {
                    $q->orWhere('posts.status', '=', $searchStatus);
                }
            })->join('users', 'posts.user_id', '=', 'users.id'); 
        }

        $query->orderBy('publish_date', 'desc');

        $length = (int)($data['length'] ?? 5);
        $start = (int)($data['start'] ?? 0);
        $page = ($start / $length) + 1;

        $posts = $query->paginate($length, ['*'], 'page', $page);

        $dataCollection = PostResource::collection($posts);

        return [
            'draw' => (int)($data['draw'] ?? 0),
            'recordsTotal' => $posts->total(),
            'recordsFiltered' => $posts->total(),
            'data' => $dataCollection
        ];
    }
}
