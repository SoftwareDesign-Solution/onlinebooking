<?php

use App\Models\Booking;
use App\Models\SpecialBooking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ConvertMigratedBookings extends Migration
{
    public function up()
    {

        return;

        $specialBookings = SpecialBooking::all();

        foreach ($specialBookings as $specialBooking) {
            $calendarEntry = $this->findCalendarEntry($specialBooking);

            if ($calendarEntry == null) {
                continue;
            }

            $oldUser = $this->getUserFromOldDatabase($calendarEntry->user_id);

            if ($oldUser == null) {
                continue;
            }

            $newUser = $this->findNewUserForOldUser($oldUser);

            if ($newUser == null) {
                $specialBooking->name = "$oldUser->first_name $oldUser->last_name";
                $specialBooking->phone = "$oldUser->tel";
                $specialBooking->save();
                continue;
            }

            $this->convertSpecialBookingToNormalBooking($specialBooking, $newUser);
        }
    }

    public function down()
    {
        throw new Exception("cannot rollback the special bookings migration");
    }

    private function convertSpecialBookingToNormalBooking($specialBooking, $user) {
        $booking = new Booking();
        $booking->room_id = $specialBooking->room_id;
        $booking->from = $specialBooking->from;
        $booking->to = $specialBooking->to;
        $booking->user_id = $user->id;
        $booking->notes = $specialBooking->notes;

        SpecialBooking::destroy($specialBooking->id);
        $booking->save();

    }

    private function findNewUserForOldUser($oldUser)
    {
        return User::where("email", $oldUser->email)->first();
    }

    private function getUserFromOldDatabase($userId)
    {
        return DB::connection('old_database')->selectOne("SELECT * FROM event_users WHERE id=$userId");
    }

    private function findCalendarEntry(SpecialBooking $specialBooking)
    {
        $specialBookingFrom = Carbon::make($specialBooking->from);
        $date = $specialBookingFrom->toDateString();
        $time = $specialBookingFrom->toTimeString();

        return DB::connection('old_database')->selectOne(
            "SELECT * FROM event_calendar WHERE date='$date' AND time='$time'"
        );
    }

}
