<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\BookingsRepository;
use Carbon\Carbon;

class BookingsController extends Controller
{
    private $bookingRepository;

    public function __construct(BookingsRepository $bookingsRepository)
    {
        $this->bookingRepository = $bookingsRepository;
    }

    public function getBookings()
    {
        $from = request()->query('from');
        $to = request()->query('to');

        if (!$from || !$to) {
            return response()->json($this->bookingRepository->allBookings());
        }

        return response()->json($this->bookingRepository->getBookingsInRange(
            Carbon::parse($from),
            Carbon::parse($to)
        ));
    }

    public function getBooking($id)
    {
        return response()->json($this->bookingRepository->booking($id));
    }

    public function deleteBooking($id)
    {
        $this->bookingRepository->deleteBooking($id);

        return response()->noContent();
    }

}
