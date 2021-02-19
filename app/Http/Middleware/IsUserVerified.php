<?php

namespace App\Http\Middleware;

use App\Exceptions\VerificationException;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class IsUserVerified
{

    public function handle($request, $next, $redirectToRoute = null)
    {
        if (!$request->user()) {
            throw new VerificationException();
        }

        if (!($request->user() instanceof MustVerifyEmail)) {
            return $next($request);
        }

        if (!$request->user()->hasVerifiedEmail()) {
            throw new VerificationException();
        }

        return $next($request);
    }
}
