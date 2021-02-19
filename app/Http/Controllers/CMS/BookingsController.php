<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Repositories\BookingsRepository;
use App\Http\Repositories\RoomsRepository;
use App\Http\Repositories\SpecialBookingsRepository;
use App\Http\Repositories\VacationBookingsRepository;
use App\Http\Services\BookingsService;
use Carbon\Carbon;
use Carbon\Factory;

class BookingsController extends Controller
{

    private $bookingsRepository;
    private $roomsRepository;
    private $specialBookingsRepository;
    private $bookingsService;
    private $vacationBookingsRepository;

    public function __construct(BookingsRepository $bookingsRepository,
                                SpecialBookingsRepository $specialBookingsRepository,
                                VacationBookingsRepository $vacationBookingsRepository,
                                BookingsService $bookingsService,
                                RoomsRepository $roomsRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->bookingsRepository = $bookingsRepository;
        $this->roomsRepository = $roomsRepository;
        $this->specialBookingsRepository = $specialBookingsRepository;
        $this->bookingsService = $bookingsService;
        $this->vacationBookingsRepository = $vacationBookingsRepository;
    }

    public function viewAllBookings()
    {
        $rooms = $this->roomsRepository->allRooms();
        $date = $this->calculateDate();
        $bookings = $this->bookingsService->createBookingSlotsForDate($date);

        $dateFactory = new Factory([
            'locale' => 'de_DE',
            'timezone' => 'Europe/Paris',
        ]);

        return view('cms.bookings')
            ->with('hasVacationBooked', $this->vacationBookingsRepository->hasVacationBookingForDate($date))
            ->with('rooms', $rooms)
            ->with('hourSlots', $this->bookingsService->hourSlots)
            ->with('date', $date)
            ->with('dateFactory', $dateFactory)
            ->with('bookings', $bookings);
    }

    private function calculateDate(): Carbon {
        $rawDate = request()->query('date');
        $date = $rawDate ? Carbon::parse($rawDate) : null;

        if ($date == null) {
            $date = Carbon::now();
        }

        return $date;
    }


}

