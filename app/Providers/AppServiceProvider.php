<?php

namespace App\Providers;

use App\Http\Observers\DutyObserver;
use App\Http\Observers\EventObserver;
use App\Models\Duty;
use App\Models\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Duty::observe(DutyObserver::class);
        Event::observe(EventObserver::class);
    }
}
