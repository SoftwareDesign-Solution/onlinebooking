<?php

namespace App\Exceptions;

use Exception;

class BookingConflictException extends Exception
{
    public function render()
    {
        return view('app.error', [
            'message' => 'Eine Buchung für den angegebenen Zeitraum existiert bereits. Wir arbeiten an der Behebung des Fehlers. Bitte rufe uns unter +43 1 587 54 64 an um diesen Slot zu buchen, wenn er dir als frei angezeigt wurde.'
        ]);
    }
}
