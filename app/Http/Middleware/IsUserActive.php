<?php

namespace App\Http\Middleware;

use App\Exceptions\ActivationException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUserActive
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->active) {
            throw new ActivationException();
        }

        return $next($request);
    }
}
