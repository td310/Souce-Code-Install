<?php

namespace App\Services\New;

use App\Models\Post;
use App\Enums\PostStatus;
use Carbon\Carbon;

class NewService
{
    public function getPublishedPosts()
    {
        return Post::where('status', PostStatus::APPROVE)
            ->where('publish_date', '<=', Carbon::now())
            ->latest('publish_date')
            ->paginate(5);
    }
}
