<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\User;

class ForgotPassMail extends Mailable
{
    public $user;
    public $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Đặt lại mật khẩu')
                    ->view('emails.forgot_password');
    }
}
