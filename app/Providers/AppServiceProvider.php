<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

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
        Carbon::setLocale('id');
        $this->app->booted(function () {
            $schedule = app(Schedule::class);

            // Menjadwalkan command tiap Senin jam 2 pagi
            $schedule->command('sync:employees-from-api')
                ->weeklyOn(1, '2:00')
                ->withoutOverlapping()
                ->runInBackground();
        });
    }
}
