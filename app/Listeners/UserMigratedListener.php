<?php

namespace App\Listeners;

use App\Events\UserMigratedEvent;
use App\Http\Repositories\UsersRepository;
use App\Mail\ChangePasswordMail;
use Illuminate\Support\Facades\Mail;

class UserMigratedListener
{

    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function handle(UserMigratedEvent $event)
    {
        Mail::to($event->user)->send(new ChangePasswordMail($event->user));
    }

}
