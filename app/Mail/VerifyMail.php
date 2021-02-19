<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class VerifyMail extends Mailable
{

    private $user;
    private $verificationUrl;

    public function __construct(User $user, string $verificationUrl)
    {
        $this->user = $user;
        $this->verificationUrl = $verificationUrl;
    }

    public function build()
    {
        return $this
            ->subject("Willkommen im t-on!")
            ->text('emails.verify', [
                "user" => $this->user,
                "verificationUrl" => $this->verificationUrl
            ]);
    }
}
