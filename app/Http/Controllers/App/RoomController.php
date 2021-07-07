<?php

namespace App\Http\Controllers\App;

use App\Exceptions\BookingConflictException;
use App\Http\Controllers\Controller;
use App\Http\Repositories\BookingsRepository;
use App\Http\Repositories\GeneralRepository;
use App\Http\Repositories\RoomsRepository;
use App\Http\Services\BookingsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{

    private $roomRepository;
    private $bookingsRepository;
    private $bookingsService;
    private $generalRepository;

    public function __construct(RoomsRepository $roomRepository,
                                BookingsRepository $bookingsRepository,
                                BookingsService $bookingsService,
                                GeneralRepository $generalRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->bookingsRepository = $bookingsRepository;
        $this->bookingsService = $bookingsService;
        $this->generalRepository = $generalRepository;
    }

    public function viewRoom()
    {
        $id = request()->route()->parameter('id');
        $room = $this->roomRepository->room($id);

        if (!$room->active) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('app.room')
            ->with('room', $room);
    }

    public function bookRoom(Request $request)
    {
        $id = $request->route()->parameter('id');
        //$dateFrom = Carbon::parse($request->get('dateFrom'));
        //$dateTo = Carbon::parse($request->get('dateTo'));
        $dateFrom = Carbon::createFromFormat(config('roombooking.date_format'), $request->get('dateFrom'));
        $dateTo = Carbon::createFromFormat(config('roombooking.date_format'), $request->get('dateTo'));
        /* set minutes and seconds to 0 because creating from format without setting minutes leads to the current minutes being in the dateFrom and dateTo variables */
        $dateFrom->minute=0;
        $dateFrom->second=0;
        $dateTo->minute=0;
        $dateTo->second=0;
        $hourFrom = intval($request->get('hourFrom'));
        $hourTo = intval($request->get('hourTo'));
        $notes = $request->get('notes');
        $general = $this->generalRepository->getGeneralInformation();

        $room = $this->roomRepository->room($id);

        if (!$room->active) {
            abort(Response::HTTP_NOT_FOUND);
        }

        // We need to check all relevant date ranges for collisions before creating the bookings to avoid partial
        // bookings if dates have collisions
        for ($currentDay = $dateFrom->copy(); $currentDay->diff($dateTo)->days <= 0; $currentDay->addDay()) {
            $rangeFrom = $currentDay->copy()->hour($hourFrom);
            $rangeTo = $currentDay->copy()->hour($hourTo);
            $hasCollision = $this->bookingsService->hasBookingsInRangeForRoom($rangeFrom, $rangeTo, $id);
            if ($hasCollision) {
                throw new BookingConflictException();
            }
        }

        for ($currentDay = $dateFrom->copy(); $currentDay->diff($dateTo)->days <= 0; $currentDay->addDay()) {
            if ($currentDay->dayOfWeek == Carbon::SATURDAY || $currentDay->dayOfWeek == Carbon::SUNDAY) {
                $hourFromForDay = $hourFrom < $general->opening_hours_start_weekend ? $general->opening_hours_start_weekend : $hourFrom;
                $hourToForDay = $hourTo > $general->opening_hours_end_weekend ? $general->opening_hours_end_weekend : $hourTo;
            } else {
                $hourFromForDay = $hourFrom < $general->opening_hours_start_weekdays ? $general->opening_hours_start_weekdays : $hourFrom;
                $hourToForDay = $hourTo > $general->opening_hours_end_weekdays ? $general->opening_hours_end_weekdays : $hourTo;
            }

            $this->bookingsRepository->createBooking(
                $id,
                Auth::user()->id,
                $currentDay->copy()->hour($hourFromForDay)->minute(0)->second(0),
                $currentDay->copy()->hour($hourToForDay)->minute(0)->second(0),
                $notes
            );
        }

        return redirect("/bookings?bookingSuccessful=true");
    }

    public function viewRoomBooking()
    {
        $id = request()->route()->parameter('id');

        $general = $this->generalRepository->getGeneralInformation();

        $minHour = min($general->opening_hours_start_weekend, $general->opening_hours_start_weekdays);
        $maxHour = max($general->opening_hours_end_weekend, $general->opening_hours_end_weekdays);

        return view('app.book')
            ->with('minHour', $minHour)
            ->with('maxHour', $maxHour)
            ->with('room', $this->roomRepository->room($id));
    }
}
