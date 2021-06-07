<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Str;
use QRCode;
use LaravelQRCode\QRCodeFactory;

class BookingController extends Controller
{
	public function index(Request $request)
	{
		$status = $request->get('status');

		$trash = Booking::onlyTrashed()->orderBy('deleted_at', 'DESC');
		$cancel = Booking::where('status', 4);
		$done = Booking::where('status', 3);
		$terima = Booking::where('status', 2);
		$baru = Booking::where('status', 1);

		$trash_count = $trash->count();
		$cancel_count = $cancel->count();
		$terima_count = $terima->count();
		$selesai_count = $done->count();
		$booking_count = $baru->count();

		if($status == 'trash'){
			// Status Sampah
			$records = $trash->orderBy('id', 'DESC')->get();
		}
		else if($status == 'cancel'){
			// Status Cancel
			$records = $cancel->orderBy('id', 'DESC')->get();
		}
		else if ($status == 'selesai') {
			// Status Selesai
			$records = $done->orderBy('id', 'DESC')->get();
		}
		else if($status == 'terima'){
			// Status Diterima
			$records = $terima->orderBy('id', 'DESC')->get();
		}
		else{
			$records = $baru->orderBy('id', 'DESC')->get();
		}

		return view('pages.booking.index',compact('records','status','booking_count','selesai_count','trash_count','terima_count','cancel_count'));
	}

	public function create(){
		return view('pages.booking.create');
	}

	public function store(Request $request)
	{
		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		$newIdBooking = 'KO0001';

		$lastBooking = Booking::orderBy('id','desc')->withTrashed()->first();

		if ($lastBooking)
		{
			$lastIdBooking = $lastBooking->id_produk;
			$intIdBooking = (int) substr($lastIdBooking,8);
			// dd($intIdBooking);
			$nextNumber = $intIdBooking + 1;
            // dd($nextNumber);
			$newIdBooking = "KO".sprintf("%04d", $nextNumber);
		}

		$encryptedCode = base64_encode($newIdBooking);

		$strRandom = Str::random(5);
		$date = date('dFY', strtotime(now()))."";
		$qrcode_name = 'generate_qrcode/'.$strRandom."_".$date.'_qr.png';

		$newQrcode = QRCode::text($encryptedCode)
							->setSize(8)
							->setMargin(2)
							->setOutfile($qrcode_name)
							->png();

		$path_foto = null;

		if ($request->hasFile('foto')) {
			$image      = $request->file('foto');
			$fileName   = 'produk_'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('foto')->storeAs('/produk',$fileName,'public');
			$path_foto = $fileName;
		}

		Booking::create([
			'nama'=>$request->nama,
			'harga' => $harga,
			'deskripsi' => $request->deskripsi,
			'foto' => $path_foto,
            'stok' => $request->stok
		]);

		return redirect()->route('booking.index')->with('msg',['type'=>'success','text'=>'Booking berhasil ditambahkan!']);
	}

	public function edit($id)
	{
		$booking = Booking::where('id', $id)->first();

		return view('pages.booking.edit', compact('booking'));
	}

	public function update(Request $request, $id)
	{
		$booking = Booking::where('id',$id)->first();

		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		$path_foto = $booking->foto;

		if ($request->hasFile('foto')) {
			$image      = $request->file('foto');
			$fileName   = 'booking_'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('foto')->storeAs('/booking',$fileName,'public');
			\File::delete(storage_path('app/public/booking/'.$booking->foto));
			$path_foto = $fileName;
		}

		$booking->nama = $request->nama;
		$booking->harga = $harga;
		$booking->deskripsi = $request->deskripsi;
		$booking->foto = $path_foto;
		$booking->stok = $request->stok;
		$booking->update();

		return redirect()->route('booking.index')->with('msg',['type'=>'success','text'=>'Booking berhasil diperbaharui!']);
	}

	public function delete($id)
	{
		Booking::where('id',$id)->delete();
		return redirect()->route('booking.index')->with('msg',['type'=>'success','text'=>'Booking berhasil dihapus!']);
	}

	public function destroy($id)
	{
		Booking::where('id',$id)->forceDelete();
		return redirect()->route('booking.index')->with('msg',['type'=>'success','text'=>'Booking berhasil dihapus!']);
	}

	public function restore($id)
	{
		Booking::where('id',$id)->restore();
		return redirect()->route('booking.index')->with('msg',['type'=>'success','text'=>'Booking berhasil direstore!']);
	}
}
