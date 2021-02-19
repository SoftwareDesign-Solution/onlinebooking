<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapCMSRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapCMSRoutes()
    {
        Route::prefix('cms')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/cms.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
