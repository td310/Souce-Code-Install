<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PostObserver implements ShouldHandleEventsAfterCommit
{
/**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        if (!$post->slug) {
            $post->slug = generate_unique_slug($post->title);
            $post->saveQuietly();
        }
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        if ($post->isDirty('title') && $post->slug) {
            $post->slug = generate_unique_slug($post->title);
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
