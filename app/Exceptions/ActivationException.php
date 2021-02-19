<?php

namespace App\Exceptions;

use Exception;

class ActivationException extends Exception
{
    public function render()
    {
        return view('app.error', [
            'message' => 'Der Account wurde noch nicht aktiviert.'
        ]);
    }
}
