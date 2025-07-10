<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Post;
use App\Enums\PostStatus;
use Illuminate\Queue\SerializesModels;

class PostStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $status;

    public function __construct(Post $post, PostStatus $status)
    {
        $this->post = $post;
        $this->status = $status;
    }

    public function build()
    {
        $subject = "Bài viết: {$this->post->title} của bạn đã được {$this->status->label()}";
        return $this->subject($subject)
                    ->view('emails.post_status_update')
                    ->with([
                        'post' => $this->post,
                        'status' => $this->status
                    ]);
    }
}
