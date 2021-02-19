<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report($exception)
    {
        parent::report($exception);
    }

    public function render($request, $exception)
    {
        return parent::render($request, $exception);
    }
}
