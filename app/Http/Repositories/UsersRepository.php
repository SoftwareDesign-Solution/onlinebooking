<?php

namespace App\Http\Repositories;

use App\Events\UserActivatedEvent;
use App\Models\User;
use App\ObjectAssign;
use App\Util;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UsersRepository
{

    private $specialBookingsRepository;

    public function __construct(SpecialBookingsRepository $specialBookingsRepository)
    {
        $this->specialBookingsRepository = $specialBookingsRepository;
    }

    public function allUsers($sortBy = 'id', $sortDirection = 'asc')
    {
        $sortDirection = strtolower($sortDirection);

        abort_unless(in_array($sortDirection, ['desc', 'asc']), Response::HTTP_BAD_REQUEST, "Sort direction only accepts ASC or DESC (case insensitive).");

        return User::orderBy($sortBy, $sortDirection)->get();
    }

    public function searchUsers($query, $sortBy = 'id', $sortDirection = 'asc')
    {
        $sortDirection = strtolower($sortDirection);

        abort_unless(in_array($sortDirection, ['desc', 'asc']), Response::HTTP_BAD_REQUEST, "Sort direction only accepts ASC or DESC (case insensitive).");

        return User::where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->orWhere('phone', 'LIKE', "%$query%")
            ->orderBy($sortBy, $sortDirection)
            ->get();
    }

    public function user(int $id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(Response::HTTP_NOT_FOUND);
        }
        return $user;
    }

    /**
     * @throws ValidationException
     */
    public function updateUser(int $id, $update)
    {
        $this->validate(Util::toArray($update));
        $user = $this->user($id);
        $wasActivated = $user->active;
        $user = ObjectAssign::assign($user, $update);
        $user->save();

        if ($wasActivated) {
            return $user;
        }

        if ($user->active) {
            event(new UserActivatedEvent($user));
        }

        return $user;
    }

    public function deleteUser(int $id)
    {
        $this->anonymizeOldBookingsForUser($id);
        $this->convertUpcomingUncancelableBookingsForUser($id);

        // upcoming cancelable bookings will also be deleted
        User::find($id)->delete();
    }

    /**
     * @throws ValidationException
     */
    private function validate($user)
    {
        return Validator::make($user, [
            'name' => ['string', 'max:255'],
            'phone' => ['string', 'regex:/^\+?\d+$/'],
            'email' => ['string', 'email', 'max:255', 'unique:users']
        ])->validate();
    }

    private function anonymizeOldBookingsForUser($id) {
        $bookings = User::find($id)->bookings;
        $bookings->filter(function ($booking) {
            Carbon::make($booking->to)->isBefore(Carbon::now());
        })->each(function ($booking) {
            $this->specialBookingsRepository->addAnonymousSpecialBookingFromBooking($booking);
        });
    }

    private function convertUpcomingUncancelableBookingsForUser($id) {
        $bookings = User::find($id)->bookings;
        $bookings->filter(function ($booking) {
            Carbon::make($booking->to)->isBefore(Carbon::now()->addHours(72));
        })->filter(function ($booking) {
            Carbon::make($booking->to)->isAfter(Carbon::now());
        })->each(function ($booking) {
            $this->specialBookingsRepository->addSpecialBookingFromBooking($booking);
        });
    }


}
