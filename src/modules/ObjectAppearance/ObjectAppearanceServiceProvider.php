<?php

namespace Modules\ObjectAppearance;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class ObjectAppearanceServiceProvider extends RouteServiceProvider
{
    protected $namespace = 'Modules\ObjectAppearance\Controllers';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::prefix('api/objects')
            ->namespace($this->namespace)
            ->group(base_path('modules/ObjectAppearance/routes.php'));
    }
}
