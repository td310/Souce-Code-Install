<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Comment\CommentResource;

class CommentService
{
    public function storeComment(Post $post, array $data)
    {
        try {
            $comment = $post->comments()->create([
                'content' => $data['content'],
                'user_id' => Auth::id(),
                'parent_id' => $data['parent_id'] ?? null,
            ]);

            $comment->load('user', 'children');

            return [
                'comment' => new CommentResource($comment),
            ];
        } catch (\Exception $e) {
            Log::error('Comment creation failed: ' . $e->getMessage());
            return ['error' => 'Không thể tạo bình luận'];
        }
    }

    public function destroyComment(PostComment $comment)
    {
        try {
            $comment->children()->delete();
            $comment->delete();
            return ['success' => true];
        } catch (\Exception $e) {
            Log::error('Comment deletion failed: ' . $e->getMessage());
            return ['success' => false, 'error' => 'Không thể xóa bình luận'];
        }
    }

    public function getComments(Post $post)
    {
        $comments = PostComment::where('commentable_id', $post->id)
            ->where('commentable_type', Post::class)
            ->whereNull('parent_id')
            ->with(['user', 'children' => function ($query) {
                $query->with(['user', 'children']);
            }])
            ->get();

        return CommentResource::collection($comments);
    }
}