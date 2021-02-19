<?php

namespace App\Http\Middleware;

use App\Models\Room;
use Closure;
use Illuminate\Support\Facades\View;

class RoomsMiddleware
{

    public function handle($request, Closure $next)
    {
        View::share('rooms', Room::all());

        return $next($request);
    }

}
