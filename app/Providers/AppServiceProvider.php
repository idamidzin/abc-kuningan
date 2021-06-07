<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;

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
        view()->composer('*',function($view){
            $booking_baru_count = Booking::where('status', 1)->count();
            $view->with('booking_baru_count', $booking_baru_count);
        });
    }
}
