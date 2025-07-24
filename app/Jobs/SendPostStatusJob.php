<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Models\Post;
use App\Enums\PostStatus;
use App\Mail\PostStatusMail;

class SendPostStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Queueable;

    protected $post;
    protected $status;

    public function __construct(Post $post, PostStatus $status)
    {
        $this->onQueue('post-status');
        $this->post = $post;
        $this->status = $status;
    }

    public function handle(): void
    {
        Mail::to($this->post->user->email)->send(new PostStatusMail($this->post, $this->status));
    }
}
