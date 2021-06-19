<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Booking;

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

    	$booking = Booking::join('paket','paket.id','=','booking.paket_id')
    					->where('paket.for_use', 'non-member')
    					->where('booking.status', 1)
    					->orderBy('booking.hari', 'DESC')
    					->get();

    	return view('pages.customer.jadwal', compact('jadwal','title','member','booking'));
    }
}
