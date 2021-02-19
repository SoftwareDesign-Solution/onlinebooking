<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\VacationBookingsRepository;
use App\Http\Services\BookingsService;
use Carbon\Carbon;
use Illuminate\Http\Response;

class VacationBookingsController extends Controller
{
    private $bookingRepository;
    private $bookingsService;

    public function __construct(VacationBookingsRepository $bookingsRepository, BookingsService $bookingsService)
    {
        $this->bookingRepository = $bookingsRepository;
        $this->bookingsService = $bookingsService;
    }

    public function getBookings()
    {
        $from = request()->query('from');
        $to = request()->query('to');

        if (!$from || !$to) {
            return response()->json($this->bookingRepository->allVacationBookings());
        }

        return response()->json($this->bookingRepository->getBookingsInRange(Carbon::parse($from), Carbon::parse($to)));
    }

    public function getBooking($id)
    {
        return response()->json($this->bookingRepository->vacationBooking($id));
    }

    public function postBooking()
    {
        return response()->json($this->bookingRepository->addVacationBooking(
            request()->json('from'),
            request()->json('to')
        ), Response::HTTP_CREATED);
    }

    public function deleteBooking($id)
    {
        $this->bookingRepository->deleteVacationBooking($id);

        return response()->noContent();
    }

}
