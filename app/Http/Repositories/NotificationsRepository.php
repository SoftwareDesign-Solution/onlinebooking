<?php


namespace App\Http\Repositories;


use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Response;

class NotificationsRepository
{

    function notificationsForUser($userId)
    {
        return Notification::where('user_id', $userId)->get();
    }

    function markAsDisplayed($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            abort(Response::HTTP_NOT_FOUND, 'The requested notification does not exist');
        }

        $notification->last_displayed = Carbon::now()->toDateTimeString();
        $notification->save();
    }

    function createNotification($userId, $type, $content = null)
    {
        $notification = new Notification();
        $notification->user_id = $userId;
        $notification->type = $type;
        $notification->content = $content;
        $notification->save();
        return $notification;
    }

    function deleteNotification($id)
    {
        Notification::find($id)->delete();
    }

}
