<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassMail;
use Illuminate\Bus\Queueable;

class SendForgotPassJob implements ShouldQueue
{
    use Dispatchable, SerializesModels, Queueable;

    protected $user;
    protected $token;

    public function __construct(User $user, string $token)
    {
        $this->onQueue('forgot-password');
        $this->user = $user;
        $this->token = $token;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new ForgotPassMail($this->user, $this->token));
    }
}
