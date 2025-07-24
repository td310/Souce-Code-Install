<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;


class PostPolicy
{
    public function userPost(User $user, Post $post): Response
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }

    public function like(): bool
    {
        return Auth::check();
    }

    public function comment(): bool
    {
        return Auth::check();
    }
}
