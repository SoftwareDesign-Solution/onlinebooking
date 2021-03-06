<?php

namespace App\Http\Controllers\App;

use App\Exceptions\BadBookingQueryException;
use App\Exceptions\BookingCancellationTimeoutException;
use App\Http\Controllers\Controller;
use App\Http\Repositories\BookingsRepository;
use App\Http\Repositories\RoomsRepository;
use App\Http\Repositories\SpecialBookingsRepository;
use App\Http\Repositories\VacationBookingsRepository;
use App\Http\Services\BookingsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use const http\Client\Curl\AUTH_ANY;

class BookingsController extends Controller
{

    private $bookingsRepository;
    private $specialBookingsRepository;
    private $vacationBookingsRepository;
    private $roomsRepository;
    private $bookingsService;

    public function __construct(BookingsRepository $bookingsRepository,
                                SpecialBookingsRepository $specialBookingsRepository,
                                VacationBookingsRepository $vacationBookingsRepository,
                                BookingsService $bookingsService,
                                RoomsRepository $roomsRepository)
    {
        $this->bookingsRepository = $bookingsRepository;
        $this->specialBookingsRepository = $specialBookingsRepository;
        $this->vacationBookingsRepository = $vacationBookingsRepository;
        $this->roomsRepository = $roomsRepository;
        $this->bookingsService = $bookingsService;
    }

    public function findAvailableSlots(Request $request)
    {
        set_time_limit(0);

        //echo Carbon::now()->format(config('roombooking.date_format'));
        //return;

        /*
        print_r([
            'dateFrom' => $request->get("dateFrom"),
            'dateTo' => $request->get("dateTo"),
            'hourFrom' => $request->get("hourFrom"),
            'hourTo' => $request->get("hourTo"),
            'requestedRooms' => null,
            'availableSlots' => null
        ]);
        return;
        */

        // Array ( [dateFrom] => 2021-02-27T22:48:47.869Z [dateTo] => 2021-03-02T22:48:47.869Z )

        if ($request->get("dateFrom")) {
            $dateFrom = Carbon::createFromFormat(config('roombooking.date_format'), $request->get("dateFrom"))->startOfDay();
            $dateTo = $request->has("dateTo") ? Carbon::createFromFormat(config('roombooking.date_format'), $request->get("dateTo"))->endOfDay() : $dateFrom->clone();
            $hourFrom = intval($request->get("hourFrom"));
            $hourTo = intval($request->get("hourTo"));
            if ($request->get("rooms") == "") {
                throw new BadBookingQueryException();
            }

            $rooms = array_map(function ($room) {
                return intval($room);
            }, explode(',', $request->get("rooms")));

            $request->session()->put("dateFrom", $dateFrom->toISOString());
            $request->session()->put("dateTo", $dateTo->toISOString());
            $request->session()->put("hourFrom", "$hourFrom");
            $request->session()->put("hourTo", "$hourTo");
            $request->session()->put("rooms", $request->get("rooms"));
        } else {
            if (!$request->session()->get("dateFrom")) {
                throw new BadBookingQueryException();
            }

            /*
            print_r([
                'dateFrom' => $request->session()->get("dateFrom"),
                'dateTo' => $request->session()->get("dateTo"),
                'hourFrom' => $request->session()->get("hourFrom"),
                'hourTo' => $request->session()->get("hourTo"),
                'requestedRooms' => null,
                'availableSlots' => null
            ]);
            return;
            */

            $dateFrom = Carbon::parse($request->session()->get("dateFrom"))->startOfDay();
            $dateTo = $request->session()->has("dateTo") ? Carbon::parse($request->session()->get("dateTo"))->endOfDay() : $dateFrom->clone();
            $hourFrom = intval($request->session()->get("hourFrom"));
            $hourTo = intval($request->session()->get("hourTo"));
            $rooms = array_map(function ($room) {
                return intval($room);
            }, explode(',', $request->session()->get("rooms")));
        }

        $availableSlots = $this->bookingsService->findAvailableSlots($dateFrom, $dateTo, $hourFrom, $hourTo, $rooms);

        $rooms = array_map(function ($id) {
            return $this->roomsRepository->room($id);
        }, $rooms);

        /*
        print_r([
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'hourFrom' => $hourFrom,
            'hourTo' => $hourTo,
            'requestedRooms' => $rooms,
            'availableSlots' => $availableSlots
        ]);
        return;
        */

        return view('app.bookings')
            ->with("dateFrom", $dateFrom)
            ->with("dateTo", $dateTo)
            ->with("hourFrom", $hourFrom)
            ->with("hourTo", $hourTo)
            ->with("requestedRooms", $rooms)
            ->with('availableSlots', $availableSlots);
    }

    public function viewBooking($id) {
        $this->canAccessBooking($id);

        return view('app.booking')
            ->with('canCancel', $this->canCancelBooking($id))
            ->with('booking', $booking = $this->bookingsRepository->booking($id));
    }

    public function deleteBooking($id) {
        $this->canAccessBooking($id);
        $canCancel = $this->canCancelBooking($id);

        if (!$canCancel) {
            throw new BookingCancellationTimeoutException();
        }

        $this->bookingsRepository->booking($id)->delete();

        return redirect('/profile/bookings');
    }

    private function canAccessBooking($id) {
        $booking = $this->bookingsRepository->booking($id);

        if (Auth::user()->id != $booking->user_id) {
            abort(Response::HTTP_FORBIDDEN, 'The requested booking belongs to another user');
        }
    }

    private function canCancelBooking($id) {
        $booking = $this->bookingsRepository->booking($id);

        $interval = Carbon::make($booking->from)->diff(Carbon::now());
        $hoursDifference = $interval->days * 24 + $interval->h;
        return $hoursDifference >= 72;
    }
}
