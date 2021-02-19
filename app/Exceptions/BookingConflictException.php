<?php

namespace App\Exceptions;

use Exception;

class BookingConflictException extends Exception
{
    public function render()
    {
        return view('app.error', [
            'message' => 'Eine Buchung für den angegebenen Zeitraum existiert bereits.'
        ]);
    }
}
