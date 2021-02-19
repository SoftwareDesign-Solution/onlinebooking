<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function build()
    {
        return $this
            ->subject("Passwort zurcksetzen - t-on")
            ->text('emails.reset-password', [
                "resetUrl" => $this->url
            ]);
    }
}
