<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\NotificationsRepository;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
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

    public function verify(Request $request)
    {

        $user = User::findOrFail($request->route('id'));

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        //$this->deleteNotificationsByUserId($user->id);

        if ($response = $this->verified($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect($this->redirectPath())->with('verified', true);
    }

    protected function verified(Request $request)
    {
        $notifications = $this->notificationsRepository->notificationsForUser(Auth::user()->id);
        $notifications->where('type', Notification::TYPE_VERIFY_EMAIL)->each(function ($notification) {
            $this->notificationsRepository->deleteNotification($notification->id);
        });
    }

    private function deleteNotificationsByUserId($userId)
    {

        $notifications = $this->notificationsRepository->notificationsForUser($userId);
        $notifications->where('type', Notification::TYPE_VERIFY_EMAIL)->each(function ($notification) {
            $this->notificationsRepository->deleteNotification($notification->id);
        });

    }
}
