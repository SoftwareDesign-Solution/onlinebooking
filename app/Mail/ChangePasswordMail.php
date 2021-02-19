<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangePasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this
            ->subject('Neues Onlinebooking - t-on')
            ->text('emails.change-password', [
                "user" => $this->user,
                "resetPasswordUrl" => url('/password/reset?email=' . $this->user->email)
            ]);
    }
}
