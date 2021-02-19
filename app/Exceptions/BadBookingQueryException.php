<?php

namespace App\Exceptions;

use Exception;

class BadBookingQueryException extends Exception
{
    public function render()
    {
        return view('app.error', [
            'message' => 'Die eingegebenen Daten sind ungültig. Bitte die Eingabe nochmals prüfen.'
        ]);
    }
}
