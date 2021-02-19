<?php

namespace App\Http\Middleware;

use App\Models\General;
use Closure;
use Illuminate\Support\Facades\View;

class GeneralInfoMiddleware
{

    public function handle($request, Closure $next)
    {
        View::share('generalInformation', General::all()[0]);

        return $next($request);
    }

}
