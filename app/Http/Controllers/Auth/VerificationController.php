<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\NotificationsRepository;
use App\Models\Notification;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = '/';

    private $notificationsRepository;

    public function __construct(NotificationsRepository $notificationsRepository)
    {
        $this->middleware('auth');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->notificationsRepository = $notificationsRepository;
    }

    protected function verified(Request $request)
    {
        $notifications = $this->notificationsRepository->notificationsForUser(Auth::user()->id);
        $notifications->where('type', Notification::TYPE_VERIFY_EMAIL)->each(function ($notification) {
            $this->notificationsRepository->deleteNotification($notification->id);
        });
    }
}
