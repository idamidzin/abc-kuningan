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
    protected $signature = 'pengingat:jadwal';

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
        $now = \Carbon\Carbon::now();
        $hari = numberToDay($now->format('N'));

        $jam_mulai = date('H:i:s', strtotime('+60 minutes'));

        $booking = Booking::where('hari', $hari)
                                ->where('status', 1)
                                ->whereRaw('? between tanggal_mulai and tanggal_selesai',[date('Y-m-d')])
                                ->where('jam_mulai','<=',$jam_mulai)
                                ->get();

        $sucessSentToUser = 0;

        foreach ($booking as $row) {

            $to_name = $row->User->nama_lengkap;
            $to_email = $row->User->email;
            $nama_paket = $row->Paket->nama;

            $data = array(
                'name'=> $row->User->nama_lengkap, 
                'lapang' => $row->Lapang->nama, 
                'waktu' => date('H:i', strtotime($row->jam_mulai)).' sd '.date('H:i', strtotime($row->jam_selesai))
            );

            \Mail::send('pengingat_jadwal', $data, function($message) use ($to_name, $to_email, $nama_paket) {
                $message->to($to_email, $to_name)->subject('Pengingat Jadwal '.$nama_paket);
                $message->from('artostechnopay@gmail.com','Anrimusthi Badminton Centre Kuningan');
            });
            $sucessSentToUser++;
        }

        $this->info('Pengingat:jadwal Command Run Successfully!');
    }
}
