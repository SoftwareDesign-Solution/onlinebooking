<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\SpecialBookingsRepository;
use App\Http\Services\BookingsService;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SpecialBookingsController extends Controller
{
    private $bookingRepository;
    private $bookingService;

    public function __construct(SpecialBookingsRepository $bookingsRepository, BookingsService $bookingService)
    {
        $this->bookingRepository = $bookingsRepository;
        $this->bookingService = $bookingService;
    }

    public function getBookings()
    {
        $from = request()->query('from');
        $to = request()->query('to');

        if (!$from || !$to) {
            return response()->json($this->bookingRepository->allSpecialBookings());
        }

        return response()->json($this->bookingRepository->getBookingsInRange(
            Carbon::parse($from),
            Carbon::parse($to)
        ));
    }

    public function getBooking($id)
    {
        return response()->json($this->bookingRepository->specialBooking($id));
    }

    public function postBooking()
    {
        if ($this->bookingService->hasBookingsInRangeForRoom(
            Carbon::parse(request()->json('from'))->addSecond(), Carbon::parse(request()->json('to')),
            request()->json('room_id')
        )) {
            abort(Response::HTTP_CONFLICT, 'A booking already exists at the specified date range');
        }

        return response()->json($this->bookingRepository->addSpecialBooking(
            request()->json('from'),
            request()->json('to'),
            request()->json('room_id'),
            request()->json('name'),
            request()->json('phone'),
            request()->json('notes')
        ), Response::HTTP_CREATED);
    }

    public function deleteBooking($id)
    {
        $this->bookingRepository->deleteSpecialBooking($id);

        return response()->noContent();
    }

}
