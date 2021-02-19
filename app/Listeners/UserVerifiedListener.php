<?php

namespace App\Listeners;

use App\Events\UserActivatedEvent;
use App\Mail\ChangePasswordMail;
use Illuminate\Support\Facades\Mail;

class UserVerifiedListener
{

    public function handle(UserActivatedEvent $event)
    {
        Mail::to($event->user)->send(new ChangePasswordMail($event->user));
    }

}
