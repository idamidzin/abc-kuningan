<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class GeneralSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scheduler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $booking_selesai = Booking::where('tanggal_selesai', date('Y-m-d'))->get();
        dd($booking_selesai);
    }
}
