<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role != 'admin') {
            return abort(Response::HTTP_FORBIDDEN, 'Only admins are allowed');
        }

        return $next($request);
    }
}
