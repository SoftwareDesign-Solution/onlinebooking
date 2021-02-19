<?php

namespace App\Providers;

use Carbon\Carbon;
use DOMDocument;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Schema::defaultStringLength(191);
        Carbon::setLocale(config('app.locale'));
        $this->bootSVGDirective();
    }

    private function bootSVGDirective()
    {
        Blade::directive('svg', function ($arguments) {
            list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path = trim($path, "' ");
            $class = trim($class, "' ");

            $svg = new DOMDocument();
            $svg->load(public_path($path));
            $svg->documentElement->setAttribute("class", $class);

            return $svg->saveXML($svg->documentElement);
        });
    }
}
