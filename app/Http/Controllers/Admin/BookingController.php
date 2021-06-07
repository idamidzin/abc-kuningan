<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
    	$is_trash = $request->get('status') == 'trash';

		$records = Booking::query();
		$booking_count = $records->count();

		$trashes = Booking::onlyTrashed()->orderBy('deleted_at','desc');
		$trash_count = $trashes->count();

		$records = $is_trash ? $trashes->where('is_member', false)->orderBy('id', 'DESC')->get() : $records->where('is_member', false)->orderBy('id', 'DESC')->get();

		return view('pages.admin.booking.index',compact('records','is_trash','booking_count','trash_count'));
    }
}
