<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Repositories\BookingsRepository;
use App\Http\Repositories\UsersRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    private $usersRepository;

    public function __construct(UsersRepository $usersRepository,
                                BookingsRepository $bookingsRepository)
    {
        $this->middleware('auth');
        $this->usersRepository = $usersRepository;
    }

    function viewProfile()
    {
        return view('app.profile')
            ->with('user', Auth::user());
    }

    function viewBookings()
    {
        $bookingsByDate = [];

        foreach (Auth::user()->bookings as $booking) {
            if (Carbon::make($booking->from)->isBefore(Carbon::now()->startOfDay())) {
                continue;
            }

            $key = Carbon::make($booking->from)->format(config('roombooking.date_format'));

            if (!array_key_exists($key, $bookingsByDate)) {
                $bookingsByDate[$key] = [];
            }

            array_push($bookingsByDate[$key], $booking);
        }

        return view('app.profile-bookings')
            ->with('bookings', $bookingsByDate);
    }


}
