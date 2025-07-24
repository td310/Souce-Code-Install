<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentService
{
    public function storeComment(Post $post, array $data)
    {
        try {
            $comment = $post->comments()->create([
                'content' => $data['content'],
                'user_id' => Auth::id(),
            ]);
            return [
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => $comment->user->name,
                    'created_at' => format_datetime($comment->created_at),
                    'can_delete' => Auth::id() === $comment->user_id,
                ],
            ];
        } catch (\Exception $e) {
            Log::error('Comment creation failed: ' . $e->getMessage());
        }
    }

    public function destroyComment(PostComment $comment)
    {
        DB::beginTransaction();
        try {
            $comment->delete();
            return [
                'success' => true
            ];
        } catch (\Exception $e) {
            Log::error('Comment deletion failed: ' . $e->getMessage());
        }
    }
}