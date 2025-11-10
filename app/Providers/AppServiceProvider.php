<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Paginator::useTailwind();

        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, 'id_ID.UTF-8');
        date_default_timezone_set(config('app.timezone'));
    }
}
