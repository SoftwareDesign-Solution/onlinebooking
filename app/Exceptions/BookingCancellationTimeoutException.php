<?php

namespace App\Exceptions;

use Exception;

class BookingCancellationTimeoutException extends Exception
{
    public function render()
    {
        response()->setStatusCode();

        return view('app.error', [
            "message" => 'Stornierungen sind nur 72 Stunden vor dem Termin möglich!'
        ]);
    }
}
