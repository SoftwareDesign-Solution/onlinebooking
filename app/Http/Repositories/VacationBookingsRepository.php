<?php


namespace App\Http\Repositories;


use App\Models\VacationBooking;
use App\Util;
use Carbon\Carbon;
use Illuminate\Http\Response;

class VacationBookingsRepository
{

    public function allVacationBookings()
    {
        return VacationBooking::all();
    }

    public function vacationBooking(int $id)
    {
        $booking = VacationBooking::find($id);
        if ($booking == null) {
            abort(Response::HTTP_NOT_FOUND);
        }
        return $booking;
    }

    public function deleteVacationBooking(int $id)
    {
        VacationBooking::destroy($id);
    }

    public function hasVacationBookingForDate(Carbon $date)
    {
        return $this->getVacationBookingForDate($date)->count() > 0;
    }

    public function getVacationBookingForDate(Carbon $date)
    {
        $from = $date->clone()->startOfDay()->format(Util::DB_DATE_FORMAT);
        $to = $date->clone()->endOfDay()->format(Util::DB_DATE_FORMAT);

        return VacationBooking::where('from', '>=', $from)
            ->where('to', '<=', $to)
            ->get();
    }

    public function getBookingsInRange(Carbon $from, Carbon $to)
    {
        $from = $from->format(Util::DB_DATE_FORMAT);
        $to = $to->format(Util::DB_DATE_FORMAT);

        return VacationBooking::whereRaw("(`from` <= ? AND `to` >= ?)", [$from, $to])
            ->orWhereRaw("(`from` > ? AND `from` < ?)", [$from, $to])
            ->orWhereRaw("(`to` > ? AND `to` < ?)", [$from, $to])
            ->get();
    }

    public function addVacationBooking($from, $to)
    {
        $booking = new VacationBooking();
        $booking->from = $from;
        $booking->to = $to;
        $booking->save();
        return $booking;
    }

}
