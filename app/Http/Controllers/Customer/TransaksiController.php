<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Booking;
use App\Models\Lapang;
use App\Models\Jadwal;
use App\Models\Diklat;

class TransaksiController extends Controller
{
	public function index(Request $request)
	{
		$title = 'Daftar Transaksi';
		$transaksi = Booking::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
		return view('pages.customer.transaksi', compact('transaksi','title'));
	}

    public function beliPaket(Request $request, $id)
    {
    	$title = 'Checkout';
		$paket = Paket::where('id', $id)->first();
		$lapang = Lapang::get();
		$jadwal = Jadwal::get();
		return view('pages.customer.checkout', compact('paket', 'title', 'lapang','jadwal'));
    }

    public function getEndTime(Request $request)
	{
		$paket = Paket::where('id', $request->paket_id)->first();

		if ($paket->for_use == 'member') {
			$end_time = date('H:i:s', strtotime('+'.$paket->jumlah_jam.' minutes', strtotime($request->start_time)));

			$cek_booking = Booking::where('paket_id', $paket->id)
									->whereRaw('? between tanggal_mulai and tanggal_selesai',[$request->tanggal_mulai])
									->where('lapang_id', $request->lapang_id)
									->where('hari', numberToDay($request->hari))
									->whereRaw('? between jam_mulai and jam_selesai',[date('H:i:s', strtotime($request->start_time))])
									->orWhereRaw('? between jam_mulai and jam_selesai',[$end_time])
									->get();

			$cek_jadwal = Jadwal::where('lapang_id', $request->lapang_id)
									->where('hari', numberToDay($request->hari))
									->whereRaw('? between jam_mulai and jam_selesai',[date('H:i:s', strtotime($request->start_time))])
									->orWhereRaw('? between jam_mulai and jam_selesai',[$end_time])
									->get();

			if (count($cek_booking) > 0 || count($cek_jadwal)) {
				$status = true;
			}else{
				$status = false;
			}

			$records = [
				'end_time' => $end_time,
				'status' => $status
			];
		}

		echo json_encode($records);
	}

    public function getEndDate(Request $request)
	{
		$paket = Paket::where('id', $request->paket_id)->first();

		if ($paket->for_use == 'member') {
			$end_time = date('H:i:s', strtotime('+'.$paket->jumlah_jam.' minutes', strtotime($request->start_time)));
			$end_date = date('Y-m-d', strtotime('+'.$paket->jumlah_hari.' days', strtotime($request->tanggal_mulai)));

			$cek_booking = Booking::where('paket_id', $paket->id)
									->whereRaw('? between tanggal_mulai and tanggal_selesai',[$request->tanggal_mulai])
									->where('lapang_id', $request->lapang_id)
									->where('hari', numberToDay($request->hari))
									->whereRaw('? between jam_mulai and jam_selesai',[date('H:i:s', strtotime($request->start_time))])
									->orWhereRaw('? between jam_mulai and jam_selesai',[$end_time])
									->get();

			$cek_jadwal = Jadwal::where('lapang_id', $request->lapang_id)
									->where('hari', numberToDay($request->hari))
									->whereRaw('? between jam_mulai and jam_selesai',[date('H:i:s', strtotime($request->start_time))])
									->orWhereRaw('? between jam_mulai and jam_selesai',[$end_time])
									->get();

			if (count($cek_booking) > 0 || count($cek_jadwal)) {
				$status = true;
			}else{
				$status = false;
			}

			$records = [
				'end_time' => $end_time,
				'end_date' => $end_date,
				'status' => $status
			];
		}

		echo json_encode($records);
	}

    public function getKetersediaanBooking(Request $request)
	{
		$paket = Paket::where('id', $request->paket_id)->first();

		$end_time = date('H:i:s', strtotime('+'.$paket->jumlah_jam.' minutes', strtotime($request->start_time)));

		$cek_booking = Booking::where('paket_id', $paket->id)
								->whereRaw('? between tanggal_mulai and tanggal_selesai',[$request->tanggal_mulai])
								->where('lapang_id', $request->lapang_id)
								->where('hari', numberToDay($request->hari))
								->whereRaw('? between jam_mulai and jam_selesai',[date('H:i:s', strtotime($request->start_time))])
								->orWhereRaw('? between jam_mulai and jam_selesai',[$end_time])
								->get();

		$cek_jadwal = Jadwal::where('lapang_id', $request->lapang_id)
								->where('hari', numberToDay($request->hari))
								->whereRaw('? between jam_mulai and jam_selesai',[date('H:i:s', strtotime($request->start_time))])
								->orWhereRaw('? between jam_mulai and jam_selesai',[$end_time])
								->get();

		if (count($cek_booking) > 0 || count($cek_jadwal)) {
			$status = true;
		}else{
			$status = false;
		}

		$records = [
			'end_time' => $end_time,
			'status' => $status
		];

		echo json_encode($records);
	}

	public function getJadwal(Request $request)
	{
		$jadwal = Jadwal::where('id', $request->jadwal_id)->first();
		$paket = Paket::where('id', $request->paket_id)->first();
		$cek_booking_diklat = Booking::where('user_id', auth()->user()->id)
										->where('jadwal_id', $jadwal->id)
										->where('paket_id', $request->paket_id)
										->whereIn('status', [0,1,2])
										->get();
		if (count($cek_booking_diklat) > 0) {
			$booking_sebelumnya = 'sudah';
			$harga_perbulan = $paket->harga_perbulan*$request->jumlah_bulan;
		}else{
			$booking_sebelumnya = 'belum';
			$potong_harga = $paket->harga - $paket->harga_perbulan;
			if ($request->jumlah_bulan <= 1) {
				$harga_perbulan = ($paket->harga_perbulan*$request->jumlah_bulan);
			}else{
				$harga_perbulan = ($paket->harga_perbulan*$request->jumlah_bulan) + $potong_harga;
			}
		}

		$tanggal_selesai = date('Y-m-d', strtotime('+'.$request->jumlah_bulan.' month', strtotime($request->tanggal_mulai)));

		$records = [
			'id' => $jadwal->id,
			'lapang' => $jadwal->Lapang->nama,
			'jam_mulai' => $jadwal->jam_mulai,
			'jam_selesai' => $jadwal->jam_selesai,
			'hari' => ucwords($jadwal->hari),
			'booking_sebelumnya' => $booking_sebelumnya,
			'harga_perbulan' => 'Rp.'.number_format($harga_perbulan,0,',','.'),
			'tanggal_selesai' => $tanggal_selesai
		];
		echo json_encode($records);
	}

	public function cekTanggalBerakhirDiklat(Request $request)
	{
		$tanggal_selesai = date('Y-m-d', strtotime('+'.$request->jumlah_bulan.' month', strtotime($request->tanggal_mulai)));
		echo json_encode([
			'tanggal_selesai' => $tanggal_selesai
		]);
	}

	public function booking(Request $request)
	{
		$paket = Paket::where('id', $request->paket_id)->first();
		
		if ($paket->for_use == 'member')
		{
			$jam_mulai = date('H:i:s', strtotime($request->start_time));
			$jam_selesai = date('H:i:s', strtotime($request->end_time));
			$hari = numberToDay($request->hari);

			$booking = Booking::create([
				'user_id' => auth()->user()->id,
				'paket_id' => $paket->id,
				'lapang_id' => $request->lapang_id,
				'hari' => $hari,
				'tanggal_mulai' => $request->tanggal_mulai,
				'tanggal_selesai' => $request->tanggal_selesai,
				'jam_mulai' => $jam_mulai,
				'jam_selesai' => $jam_selesai,
				'jumlah_hari' => $paket->jumlah_hari,
				'keterangan' => NULL,
				'harga' => $paket->harga,
				'status' => 0,
				'diskon' => $paket->diskon ? $paket->diskon : NULL,
				'bukti_pembayaran' => NULL,
				'is_member' => true,
			]);

			return redirect()->route('home')->with('msg',['type'=>'success','text'=>'Member berhasil diajukan!']);
		}
		else if($paket->for_use == 'diklat')
		{
			$harga = preg_replace('/[Rp.]/', '', $request->total_bayar);
			$hari = strtolower($request->hari);
			$jam_mulai = date('H:i:s', strtotime($request->start_time));
			$jam_selesai = date('H:i:s', strtotime($request->end_time));

			$jadwal = Jadwal::where('id', $request->jadwal_id)->first();

			$booking = Booking::create([
				'user_id' => auth()->user()->id,
				'paket_id' => $paket->id,
				'lapang_id' => $jadwal->lapang_id,
				'jadwal_id' => $jadwal->id,
				'hari' => $hari,
				'tanggal_mulai' => $request->tanggal_mulai,
				'tanggal_selesai' => $request->tanggal_selesai,
				'jam_mulai' => $jam_mulai,
				'jam_selesai' => $jam_selesai,
				'jumlah_hari' => $paket->jumlah_hari,
				'keterangan' => NULL,
				'harga' => $harga,
				'status' => 0,
				'diskon' => $paket->diskon ? $paket->diskon : NULL,
				'bukti_pembayaran' => NULL,
				'is_member' => false,
			]);

			return redirect()->route('home')->with('msg',['type'=>'success','text'=>'Pelatihan berhasil diajukan!']);
		}
		else
		{
			$jam_mulai = date('H:i:s', strtotime($request->start_time));
			$jam_selesai = date('H:i:s', strtotime($request->end_time));
			$hari = numberToDay($request->hari);

			$booking = Booking::create([
				'user_id' => auth()->user()->id,
				'paket_id' => $paket->id,
				'lapang_id' => $request->lapang_id,
				'hari' => $hari,
				'tanggal_mulai' => $request->tanggal_mulai,
				'tanggal_selesai' => $request->tanggal_mulai, // Tanggal selesai sama dengan tanggal mulai
				'jam_mulai' => $jam_mulai,
				'jam_selesai' => $jam_selesai,
				'jumlah_hari' => $paket->jumlah_hari,
				'keterangan' => NULL,
				'harga' => $paket->harga,
				'status' => 0,
				'diskon' => $paket->diskon ? $paket->diskon : NULL,
				'bukti_pembayaran' => NULL,
				'is_member' => false,
			]);

			return redirect()->route('home')->with('msg',['type'=>'success','text'=>'Booking berhasil diajukan!']);
		}
	}

	public function upload(Request $request)
	{
		$transaksi = Booking::where('id', $request->id)->first();

		$path_bukti = $transaksi->bukti_pembayaran;

		if ($request->hasFile('bukti_pembayaran')) {
			$image      = $request->file('bukti_pembayaran');
			$fileName   = 'bukti_'.auth()->user()->hashid.'.' . $image->getClientOriginalExtension();
			$request->file('bukti_pembayaran')->storeAs('/bukti_pembayaran',$fileName,'public');
			\File::delete(storage_path('app/public/bukti_pembayaran/'.$transaksi->bukti_pembayaran));
			$path_bukti = $fileName;
		}

		$transaksi->bukti_pembayaran = $path_bukti;
		$transaksi->update();

		return redirect()->back()->with('msg', ['type' => 'success', 'text' => 'Bukti Pembayaran Berhasil dikirim !']);
	}

	public function delete($id)
	{
		Booking::where('id',$id)->forceDelete();
		return redirect()->back()->with('msg',['type'=>'success','text'=>'Transaksi berhasil dihapus!']);
	}

}
