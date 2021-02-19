<?php


namespace App\Http\Repositories;


use App\Models\Booking;
use App\Util;
use Carbon\Carbon;
use Illuminate\Http\Response;

class BookingsRepository
{

    public function allBookings()
    {
        return Booking::all();
    }

    public function booking(int $id)
    {
        $booking = Booking::find($id);
        if ($booking == null) {
            abort(Response::HTTP_NOT_FOUND);
        }
        return $booking;
    }

    public function createBooking(int $roomId, int $userId, Carbon $dateFrom, Carbon $dateTo, string $notes = null)
    {
        $booking = new Booking();
        $booking->room_id = $roomId;
        $booking->user_id = $userId;
        $booking->from = $dateFrom->timestamp;
        $booking->to = $dateTo->timestamp;
        $booking->notes = $notes;
        $booking->save();
    }

    public function deleteBooking(int $id)
    {
        Booking::destroy($id);
    }

    public function getBookingsForRoom(int $roomId, $from, $to)
    {
        return Booking::where('room_id', $roomId)
            ->where('from', '>=', $from)
            ->where('to', '<=', $to)
            ->get();
    }

    public function getBookingsInRange(Carbon $from, Carbon $to)
    {
        $from = $from->format(Util::DB_DATE_FORMAT);
        $to = $to->format(Util::DB_DATE_FORMAT);

        return Booking::whereRaw("(`from` <= ? AND `to` >= ?)", [$from, $to])
            ->orWhereRaw("(`from` > ? AND `from` < ?)", [$from, $to])
            ->orWhereRaw("(`to` > ? AND `to` < ?)", [$from, $to])
            ->get();
    }

    public function getBookingsInRangeForRoom(Carbon $from, Carbon $to, int $roomId)
    {
        $from = $from->format(Util::DB_DATE_FORMAT);
        $to = $to->format(Util::DB_DATE_FORMAT);

        return Booking::whereRaw("(`from` <= ? AND `to` >= ?)", [$from, $to])
            ->orWhereRaw("(`from` > ? AND `from` < ?)", [$from, $to])
            ->orWhereRaw("(`to` > ? AND `to` < ?)", [$from, $to])
            ->where('room_id', $roomId)
            ->get();
    }

    public function getBookingsForDate(Carbon $date)
    {
        return Booking::where('from', '>=', $date->startOfDay()->format(Util::DB_DATE_FORMAT))
            ->where('to', '<=', $date->endOfDay()->format(Util::DB_DATE_FORMAT))
            ->get();
    }

}
