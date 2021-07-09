<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Booking;
use Response;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
    	$title = 'Jadwal';
    	$jadwal = Jadwal::get();

    	$member = Booking::join('paket','paket.id','=','booking.paket_id')
    					->where('paket.for_use', 'member')
    					->where('booking.status', 1)
    					->orderBy('booking.hari', 'DESC')
    					->get();

        $data_diklat = \Carbon\CarbonPeriod::create('2021-06-07','2051-08-07');

        $tgl_default = date('Y-m-d');

        $row_tanggal_member=[];   
        $tanggal_list_member=[];   
        foreach ($member as $row) {
            $tanggals=[];   
                $row_tanggal_member = \Carbon\CarbonPeriod::create($row->tanggal_mulai, $row->tanggal_selesai);
                foreach ($row_tanggal_member as $tgl) {
                    if(numberToDay($tgl->format("N")) == $row->hari){
                        $tanggals []=[
                            'nama' => $row->Paket->nama.'\n'.date('H:i', strtotime($row->jam_mulai)).'sd'.date('H:i', strtotime($row->jam_selesai)).'\n'.$row->Lapang->nama,
                            'tgl' => $tgl->format('Y-m-d'),
                            'member' => $row->User->nama_lengkap
                        ];
                    }
                }
                $tanggal_list_member[] = [
                    'event' => $tanggals
                ];
        }

        $data_member = [];
        foreach ($tanggal_list_member as $key => $value) {
            foreach ($value['event'] as $key1 => $value1) {
                $data_member [] = (object) [
                    'title' => $value1['nama'],
                    'start' => $value1['tgl'],
                    'end' => $value1['tgl']
                ];
            }
        }

        $booking = Booking::join('paket','paket.id','=','booking.paket_id')
                        ->where('paket.for_use', 'non-member')
                        ->where('booking.status', 1)
                        ->orderBy('booking.hari', 'DESC')
                        ->get();

        $row_tanggal_booking=[];   
        $tanggal_list_booking=[];   
        foreach ($booking as $row) {
            $tanggals=[];   
                $row_tanggal_booking = \Carbon\CarbonPeriod::create($row->tanggal_mulai, $row->tanggal_selesai);
                foreach ($row_tanggal_booking as $tgl) {
                    if(numberToDay($tgl->format("N")) == $row->hari){
                        $tanggals []=[
                            'nama' => $row->Paket->nama.'\n'.date('H:i', strtotime($row->jam_mulai)).'sd'.date('H:i', strtotime($row->jam_selesai)).'\n'.$row->Lapang->nama,
                            'tgl' => $tgl->format('Y-m-d'),
                            'member' => $row->User->nama_lengkap
                        ];
                    }
                }
                $tanggal_list_booking[] = [
                    'event' => $tanggals
                ];
        }

        $data_booking = [];
        foreach ($tanggal_list_booking as $key => $value) {
            foreach ($value['event'] as $key1 => $value1) {
                $data_booking [] = (object) [
                    'title' => $value1['nama'],
                    'start' => $value1['tgl'],
                    'end' => $value1['tgl']
                ];
            }
        }


    	return view('pages.customer.jadwal', compact('jadwal','title','member','booking','data_diklat', 'tgl_default', 'data_member','data_booking'));
    }
}
