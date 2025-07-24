<?php

namespace App\Services\User;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\User\PostResource;

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
        try {
            $post->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Post deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteAllPosts()
    {
        try {
            Auth::user()->posts()->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Bulk post deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getDataTableData(array $data)
    {
        $query = Post::with(['user', 'media'])
            ->where('user_id', Auth::id());

        $searchTitle = $data['title'] ?? null;
        $searchStatus = isset($data['status']) && $data['status'] !== '' ? (int)$data['status'] : null;

        if (!empty($searchTitle) || !is_null($searchStatus)) {
            $query->where(function ($q) use ($searchTitle, $searchStatus) {
                if (!empty($searchTitle)) {
                    $q->where('title', 'like', "%{$searchTitle}%");
                }
                if (!is_null($searchStatus)) {
                    $q->orWhere('status', '=', $searchStatus);
                }
            });
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
