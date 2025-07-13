<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MortgageServiceProvider extends ServiceProvider
{
    protected string $namespace = 'App\\Modules\\Mortgage\\Controllers';
    public function register(): void
    {
        //
    }

    public function boot()
    {
       $this->mapApiRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('app/Modules/Mortgage/Routes/api.php'));
    }
}
