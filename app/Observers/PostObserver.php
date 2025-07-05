<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PostObserver
{
    public function creating(Post $post): void
    {
        if (!$post->slug) {
            $slug = Str::slug($post->title);
            $hashSlug = substr(md5(uniqid($slug, true)), 0, 6);
            $post->slug = "{$slug}-{$hashSlug}";
        }
    }

    public function created(Post $post): void
    {
        //
    }

    public function updating(Post $post): void
    {
        if ($post->isDirty('title') && $post->slug) {
            $slug = Str::slug($post->title);
            $hashSlug = substr(md5(uniqid($slug, true)), 0, 6);
            $post->slug = "{$slug}-{$hashSlug}";
        }
    }

    public function updated(Post $Post): void
    {
        //
    }

    public function deleted(Post $Post): void
    {
        //
    }

    public function restored(Post $Post): void
    {
        //
    }

    public function forceDeleted(Post $Post): void
    {
        //
    }
}
