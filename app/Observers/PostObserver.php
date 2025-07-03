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
        Log::info('data observer');
        $originalSlug = Str::slug($post->title);
        $slug = $originalSlug;
        $count = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $post->slug = $slug;
        Log::info('data observer', $post->toArray());
    }

    public function created(Post $post): void
    {
        // $originalSlug = Str::slug($post->title);
        // $slug = $originalSlug;
        // $count = 1;

        // while (Post::where('slug', $slug)->exists()) {
        //     $slug = $originalSlug . '-' . $count++;
        // }
        // $post->slug = $slug;
        // $post->save();
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
