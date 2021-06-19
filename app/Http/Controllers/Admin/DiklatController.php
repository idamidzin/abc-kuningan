<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class DiklatController extends Controller
{
    public function index(Request $request)
    {
    	$status = $request->get('status');
		$tahun = !empty($request->get('tahun')) ? $request->get('tahun') : date('Y');
        $bulan = !empty($request->get('bulan')) ? $request->get('bulan') : date('m');

		$trash = Booking::join('paket', 'paket.id','=','booking.paket_id')
								->where('paket.for_use', 'diklat')
								->onlyTrashed()
								->orderBy('booking.deleted_at', 'DESC')
								->whereRaw('MONTH(booking.created_at) = ? and YEAR(booking.created_at) = ?',[$bulan,$tahun]);

		$cancel = Booking::join('paket', 'paket.id','=','booking.paket_id')
								->where('paket.for_use', 'diklat')
								->where('booking.status', 3)
								->whereRaw('MONTH(booking.created_at) = ? and YEAR(booking.created_at) = ?',[$bulan,$tahun]);

		$done = Booking::join('paket', 'paket.id','=','booking.paket_id')
								->where('paket.for_use', 'diklat')
								->where('booking.status', 2)
								->whereRaw('MONTH(booking.created_at) = ? and YEAR(booking.created_at) = ?',[$bulan,$tahun]);

		$terima = Booking::join('paket', 'paket.id','=','booking.paket_id')
								->where('paket.for_use', 'diklat')
								->where('booking.status', 1)
								->whereRaw('MONTH(booking.created_at) = ? and YEAR(booking.created_at) = ?',[$bulan,$tahun]);

		$baru = Booking::join('paket', 'paket.id','=','booking.paket_id')
								->where('paket.for_use', 'diklat')
								->where('booking.status', 0)
								->where('booking.status_pembayaran', 0)->whereRaw('MONTH(booking.created_at) = ? and YEAR(booking.created_at) = ?',[$bulan,$tahun]);

		$trash_count = $trash->count();
		$cancel_count = $cancel->count();
		$terima_count = $terima->count();
		$selesai_count = $done->count();
		$diklat_count = $baru->count();

		if($status == 'trash'){
			// Status Sampah
			$records = $trash->orderBy('booking.id', 'DESC')->select('booking.*')->get();
		}
		else if($status == 'cancel'){
			// Status Cancel
			$records = $cancel->orderBy('booking.id', 'DESC')->select('booking.*')->get();
		}
		else if ($status == 'selesai') {
			// Status Selesai
			$records = $done->orderBy('booking.id', 'DESC')->select('booking.*')->get();
		}
		else if($status == 'terima'){
			// Status Diterima
			$records = $terima->orderBy('booking.id', 'DESC')->select('booking.*')->get();
		}else{
			$records = $baru->orderBy('booking.id', 'DESC')->select('booking.*')->get();
		}

		return view('pages.admin.diklat.index',compact('records','status','diklat_count','selesai_count','trash_count','terima_count','cancel_count','tahun', 'bulan'));
    }

    public function proses(Request $request, $id)
	{
		$booking = Booking::where('id', $id)->first();

		if ($booking) {
			$booking->status = $request->get('param');
			$booking->update();
		}

		return back()->with('msg',['type'=>'success','text'=>'Diklat berhasil diterima!'])->withInput();
	}

	public function delete($id)
	{
		Booking::where('id',$id)->delete();
		return redirect()->route('admin.diklat.index')->with('msg',['type'=>'success','text'=>'Diklat berhasil dihapus!']);
	}

	public function destroy($id)
	{
		Booking::where('id',$id)->forceDelete();
		return redirect()->route('admin.diklat.index')->with('msg',['type'=>'success','text'=>'Diklat berhasil dihapus!']);
	}

	public function restore($id)
	{
		Booking::where('id',$id)->restore();
		return redirect()->route('admin.diklat.index')->with('msg',['type'=>'success','text'=>'Diklat berhasil direstore!']);
	}
}
