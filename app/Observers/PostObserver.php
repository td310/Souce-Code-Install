<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PostObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the User "created" event.
     */
    public function created(Post $post): void
    {
        if (!$post->slug) {
            $slug = Str::slug($post->title);
            $hashSlug = substr(md5(uniqid($slug, true)), 0, 6);
            $post->slug = "{$slug}-{$hashSlug}";
            $post->saveQuietly();
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(Post $post): void
    {
        if ($post->isDirty('title') && $post->slug) {
            $slug = Str::slug($post->title);
            $hashSlug = substr(md5(uniqid($slug, true)), 0, 6);
            $post->slug = "{$slug}-{$hashSlug}";
            $post->saveQuietly();
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
