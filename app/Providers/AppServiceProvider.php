<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('rupiah', function ( $expression ) { return "Rp. <?php echo number_format($expression,0,',','.'); ?>"; });
        date_default_timezone_set('Asia/Jakarta');
        view()->composer('layouts.horizontal', function ($view){

            if (auth()->user()) {
                $booking = Booking::where('user_id', auth()->user()->id);

                $booking_count = $booking->whereIn('status', [0,1])->get()->count();
                $transaksi_baru_count = $booking->where('status', 0)->where('bukti_pembayaran', NULL)->get()->count();
                $paket_aktif_count = $booking->where('status', 1)->get()->count();
            }else{
                $booking_count = 0;
                $transaksi_baru_count = 0;
                $paket_aktif_count = 0;
            }

            $view->with('booking_count', $booking_count);
            $view->with('transaksi_baru_count', $transaksi_baru_count);
            $view->with('paket_aktif_count', $paket_aktif_count);

        });
        view()->composer('*',function($view){
            $booking_baru_count = Booking::where('status', 1)->count();
            $view->with('booking_baru_count', $booking_baru_count);
        });
    }
}
