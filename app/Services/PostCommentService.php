<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostCommentService
{
    public function storeComment(Post $post, array $data)
    {
        try {
            DB::beginTransaction();
            $comment = $post->comments()->create([
                'content' => $data['content'],
                'user_id' => Auth::id(),
            ]);
            DB::commit();
            return [
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => $comment->user->name,
                    'created_at' => $comment->created_at->format('d/m/Y H:i'),
                    'can_delete' => Auth::id() === $comment->user_id,
                ],
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Comment creation failed: ' . $e->getMessage());
        }
    }

    public function destroyComment(PostComment $comment)
    {
        try {
            DB::beginTransaction();
            $comment->delete();
            DB::commit();
            return [
                'success' => true
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Comment deletion failed: ' . $e->getMessage());
        }
    }
}