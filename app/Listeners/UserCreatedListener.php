<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use App\Http\Repositories\UsersRepository;
use App\Mail\ChangePasswordMail;
use App\Mail\NewUserMail;
use Illuminate\Support\Facades\Mail;

class UserCreatedListener
{

    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function handle(UserCreatedEvent $event)
    {
        if ($event->user->active) {
            return;
        }

        $admins = $this->usersRepository->allUsers()->where('role', 'admin');
        Mail::to($admins)->send(new NewUserMail($event->user));
    }

}
