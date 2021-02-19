<?php

use App\Models\SpecialBooking;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ImportBookingsData extends Migration
{

    public function up()
    {

        if (env('APP_ENV') == 'pipeline') {
            return;
        }

        $calendar = $this->fetchCalendarFromOldDatabase();

        foreach ($calendar as $calendarEntry) {
            $specialBooking = new SpecialBooking();
            $specialBooking->room_id = $calendarEntry->room;
            $specialBooking->phone = $this->guessPhone($calendarEntry);
            $specialBooking->name = $this->guessName($calendarEntry);
            $specialBooking->notes = $calendarEntry->note;
            $specialBooking->notes = $calendarEntry->note;
            $specialBooking->from = Carbon::make($calendarEntry->date)
                ->startOfDay()
                ->setHour($calendarEntry->time);
            $specialBooking->to = $specialBooking->from->clone()->addHour();
            $specialBooking->created_at = Carbon::make($calendarEntry->log_time);
            $specialBooking->save();
        }
    }

    public function down()
    {
        if (env('APP_ENV') == 'pipeline') {
            return;
        }

        foreach(SpecialBooking::all() as $booking) {
            $booking->delete();
        }
    }

    private function guessName($calendarEntry) {
        if (preg_match("/, /i", $calendarEntry->note)) {
            return explode(', ', $calendarEntry->note)[0];
        }

        return explode(' ', $calendarEntry->note)[0];
    }

    private function guessPhone($calendarEntry) {
        $pattern = "/\d{5}\d+/i";
        $matches = [];
        $hasMatch = preg_match_all($pattern, $calendarEntry->note, $matches);
        return $hasMatch ? $matches[0][0] : null;
    }

    private function fetchCalendarFromOldDatabase()
    {
        return DB::connection('old_database')->select('SELECT * FROM event_calendar');
    }
}
