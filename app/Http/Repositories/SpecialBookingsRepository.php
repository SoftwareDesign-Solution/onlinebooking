<?php


namespace App\Http\Repositories;


use App\Models\SpecialBooking;
use App\Util;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SpecialBookingsRepository
{

    public function allSpecialBookings()
    {
        return SpecialBooking::all();
    }

    public function specialBooking(int $id)
    {
        $booking = SpecialBooking::find($id);
        if ($booking == null) {
            abort(Response::HTTP_NOT_FOUND);
        }
        return $booking;
    }

    public function deleteSpecialBooking(int $id)
    {
        SpecialBooking::destroy($id);
    }

    public function getSpecialBookingsForRoom(int $roomId, $from, $to)
    {
        return SpecialBooking::where('room_id', $roomId)
            ->where('from', '>=', $from)
            ->where('to', '<=', $to)
            ->get();
    }

    public function getSpecialBookingsForDate(Carbon $date)
    {
        return SpecialBooking::where('from', '>=', $date->startOfDay()->format(Util::DB_DATE_FORMAT))
            ->where('to', '<=', $date->endOfDay()->format(Util::DB_DATE_FORMAT))
            ->get();
    }

    public function addSpecialBooking($from, $to, $roomId, $name, $phone = '', $notes = '') {
        $booking = new SpecialBooking();
        $booking->from = $from;
        $booking->to = $to;
        $booking->room_id = $roomId;
        $booking->name = $name;
        $booking->phone = $phone;
        $booking->notes = $notes;
        $booking->save();
        return $booking;
    }

    public function addSpecialBookingFromBooking($standardBooking) {
        $booking = new SpecialBooking();
        $booking->from = $standardBooking->from;
        $booking->to = $standardBooking->from;
        $booking->room_id = $standardBooking->roomId;
        $booking->name = $standardBooking->user->name;
        $booking->phone = $standardBooking->user->phone;
        $booking->notes = $standardBooking->notes;
        $booking->save();
        return $booking;
    }

    public function addAnonymousSpecialBookingFromBooking($standardBooking) {
        $booking = new SpecialBooking();
        $booking->from = $standardBooking->from;
        $booking->to = $standardBooking->from;
        $booking->room_id = $standardBooking->roomId;
        $booking->name = "";
        $booking->phone = "";
        $booking->notes = "";
        $booking->save();
        return $booking;
    }

    public function getBookingsInRange(Carbon $from, Carbon $to)
    {
        $from = $from->format(Util::DB_DATE_FORMAT);
        $to = $to->format(Util::DB_DATE_FORMAT);

        return SpecialBooking::whereRaw("(`from` <= ? AND `to` >= ?)", [$from, $to])
            ->orWhereRaw("(`from` > ? AND `from` < ?)", [$from, $to])
            ->orWhereRaw("(`to` > ? AND `to` < ?)", [$from, $to])
            ->get();
    }

    public function getBookingsInRangeForRoom(Carbon $from, Carbon $to, int $roomId)
    {
        $from = $from->format(Util::DB_DATE_FORMAT);
        $to = $to->format(Util::DB_DATE_FORMAT);

        return SpecialBooking::whereRaw("(`from` <= ? AND `to` >= ?)", [$from, $to])
            ->orWhereRaw("(`from` > ? AND `from` < ?)", [$from, $to])
            ->orWhereRaw("(`to` > ? AND `to` < ?)", [$from, $to])
            ->where('room_id', $roomId)
            ->get();
    }

}
