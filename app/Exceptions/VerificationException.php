<?php

namespace App\Exceptions;

use Exception;

class VerificationException extends Exception
{
    public function render()
    {
        return view('app.error', [
            'message' => 'E-Mail wurde noch nicht bestätigt.'
        ]);
    }
}
