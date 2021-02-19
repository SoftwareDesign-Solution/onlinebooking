<?php

namespace App\Http\Services;

use App\Http\Repositories\BookingsRepository;
use App\Http\Repositories\RoomsRepository;
use App\Http\Repositories\SpecialBookingsRepository;
use App\Http\Repositories\VacationBookingsRepository;
use Carbon\Carbon;

class BookingsService
{

    private $bookingsRepository;
    private $specialBookingsRepository;
    private $vacationBookingsRepository;
    private $roomsRepository;

    public $hourSlots;

    public function __construct(BookingsRepository $bookingsRepository, SpecialBookingsRepository $specialBookingsRepository,
                                VacationBookingsRepository $vacationBookingsRepository, RoomsRepository $roomsRepository)
    {
        $this->bookingsRepository = $bookingsRepository;
        $this->specialBookingsRepository = $specialBookingsRepository;
        $this->vacationBookingsRepository = $vacationBookingsRepository;
        $this->roomsRepository = $roomsRepository;
        $this->hourSlots = range(11, 23);
    }

    function hasBookingsInRange(Carbon $from, Carbon $to)
    {
        return $this->bookingsRepository->getBookingsInRange($from, $to)->count() +
            $this->vacationBookingsRepository->getBookingsInRange($from, $to)->count() +
            $this->specialBookingsRepository->getBookingsInRange($from, $to)->count() > 0;
    }

    function hasBookingsInRangeForRoom(Carbon $from, Carbon $to, int $roomId)
    {
        if ($this->vacationBookingsRepository->getBookingsInRange($from, $to)->count() > 0) {
            return true;
        }

        $bookings = $this->bookingsRepository->getBookingsInRange($from, $to);
        $specialBookings = $this->specialBookingsRepository->getBookingsInRange($from, $to);

        foreach ($bookings as $booking) {
            if ($booking->room_id == $roomId) {
                return true;
            }
        }

        foreach ($specialBookings as $booking) {
            if ($booking->room_id == $roomId) {
                return true;
            }
        }

        return false;
    }

    function createBookingSlotsForDate($date)
    {
        $rooms = $this->roomsRepository->allRooms();
        $bookings = $this->bookingsRepository->getBookingsForDate($date)->all();
        $specialBookings = $this->specialBookingsRepository->getSpecialBookingsForDate($date)->all();

        $bookings = array_merge($bookings, $specialBookings);

        $result = array();
        foreach ($rooms as $room) {
            $roomBookings = array();
            foreach ($this->hourSlots as $slot) {
                $roomBookings[$slot] = null;

                foreach ($bookings as $booking) {
                    if (!($booking->from->hour <= $slot && $booking->to->hour - 1 >= $slot)) {
                        continue;
                    }

                    if ($booking->room->id != $room->id) {
                        continue;
                    }

                    $roomBookings[$slot] = $booking;
                    break;
                }
            }
            $result[$room->id] = $roomBookings;
        }
        return $result;
    }

    public function findAvailableSlots(Carbon $dateFrom, Carbon $dateTo, int $hourFrom, int $hourTo, array $rooms)
    {
        $availableDates = [];
        $rooms = array_map(function ($id) {
            return $this->roomsRepository->room($id);
        }, $rooms);

        for ($currentDay = $dateFrom->copy()->startOfDay(); $currentDay->diff($dateTo->clone()->addDay())->days; $currentDay->addDay()) {
            //$availableDates[$currentDay->format('d-m-yy')] = []; // Liefert 17-02-2121
            $availableDates[$currentDay->format(config('roombooking.date_format'))] = [];
            $isEmpty = true;

            if ($this->vacationBookingsRepository->hasVacationBookingForDate($currentDay)) {
                continue;
            }

            if ($currentDay->isBefore(Carbon::now()->startOfDay())) {
                continue;
            }

            if ($currentDay->isToday() && Carbon::now()->hour >= $hourTo) {
                continue;
            }

            $from = $currentDay->copy()->startOfDay()->hour($hourFrom);
            $to = $currentDay->copy()->startOfDay()->hour($hourTo);
            $bookingsForRoom = $this->bookingsRepository->getBookingsInRange($from, $to);
            $specialBookingsForRoom = $this->specialBookingsRepository->getBookingsInRange($from, $to);

            $roomsPerSlot = [];
            foreach ($rooms as $room) {
                $slotsTaken = [];

                foreach ($bookingsForRoom as $booking) {
                    if ($booking->room->id != $room->id) {
                        continue;
                    }

                    $slotFrom = Carbon::make($booking->from)->hour;
                    $slotTo = Carbon::make($booking->to)->hour;

                    for ($slot = $slotFrom; $slot <= $slotTo; $slot++) {
                        array_push($slotsTaken, $slot);
                    }
                }

                foreach ($specialBookingsForRoom as $booking) {
                    if ($booking->room->id != $room->id) {
                        continue;
                    }

                    $slotFrom = Carbon::make($booking->from)->hour;
                    $slotTo = Carbon::make($booking->to)->hour;

                    for ($slot = $slotFrom; $slot <= $slotTo; $slot++) {
                        array_push($slotsTaken, $slot);
                    }
                }

                for ($hour = $hourFrom; $hour < $hourTo; $hour++) {
                    if (!array_key_exists($hour, $roomsPerSlot)) {
                        $roomsPerSlot[$hour] = [];
                    }

                    if (in_array($hour, $slotsTaken)) {
                        continue;
                    }

                    if ($currentDay->isToday() && Carbon::now()->hour >= $hour) {
                        continue;
                    }

                    array_push($roomsPerSlot[$hour], $room);
                    $isEmpty = false;
                }
            }

            if (!$isEmpty) {
                //$availableDates[$currentDay->format('d-m-yy')] = $roomsPerSlot;  // Liefert 17-02-2121
                $availableDates[$currentDay->format(config('roombooking.date_format'))] = $roomsPerSlot;
            }
        }

        return $availableDates;
    }

}
