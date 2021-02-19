<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\NotificationsRepository;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{

    private $notificationsRepository;

    public function __construct(NotificationsRepository $notificationsRepository)
    {
        $this->middleware('auth');
        $this->notificationsRepository = $notificationsRepository;
    }

    public function getNotifications()
    {
        return $this->notificationsRepository->notificationsForUser(Auth::user()->getAuthIdentifier());
    }

    public function markNotificationAsViewed($id)
    {
        $this->notificationsRepository->markAsDisplayed($id);
    }

    public function deleteNotification($id)
    {
        $this->notificationsRepository->deleteNotification($id);
    }

}
