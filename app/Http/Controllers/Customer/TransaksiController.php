<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Booking;
use App\Models\Lapang;
use App\Models\Jadwal;
use App\Models\Diklat;
use App\Models\Pembayaran;

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

		$tanggal_mulai = $request->tanggal_mulai ? $request->tanggal_mulai : date('Y-m-d');
		$jumlahHariNew = $request->jumlah_bulan*30;

		$start_time = date('H:i:s', strtotime($request->start_time));
		$end_time = date('H:i:s', strtotime('+'.$paket->jumlah_jam.' minutes', strtotime($request->start_time)));
		$end_date = date('Y-m-d', strtotime('+'.$jumlahHariNew.' days', strtotime($tanggal_mulai)));
		$lapang_id = $request->lapang_id;
		$hari = numberToDay($request->hari);

		$cek_booking = Booking::where('lapang_id', $request->lapang_id)
								->where('hari', numberToDay($request->hari))
								->whereIn('status', [0,1])
								->where(function($query) use ($tanggal_mulai, $end_date){
									$query->whereRaw('? between tanggal_mulai and tanggal_selesai',[$tanggal_mulai]);
									$query->orWhereRaw('? between tanggal_mulai and tanggal_selesai',[$end_date]);
								})
								->where(function($query) use ($start_time, $end_time){
									$query->whereRaw('? between jam_mulai and jam_selesai',[$start_time]);
									$query->orWhereRaw('? between jam_mulai and jam_selesai',[$end_time]);
								})
								->get();

		$cek_jadwal = Jadwal::where('lapang_id', $request->lapang_id)
								->where('hari', numberToDay($request->hari))
								->whereRaw('? between jam_mulai and jam_selesai',[date('H:i:s', strtotime($request->start_time))])
								->orWhereRaw('? between jam_mulai and jam_selesai',[$end_time])
								->get();

		if (strtotime($tanggal_mulai) < strtotime(date('Y-m-d'))) {
			$status = true;
		}else if (strtotime($tanggal_mulai) == strtotime(date('Y-m-d'))) {
			if (count($cek_booking) > 0 || count($cek_jadwal) > 0) {
				$status = true;
			}else{
				$status = false;
			}
		}
		else
		{
			if (count($cek_booking) > 0 || count($cek_jadwal) > 0) {
				$status = true;
			}else{
				$status = false;
			}
		}

		$records = [
			'end_time' => $end_time,
			'end_date' => $end_date,
			'total_bayar' => 'Rp.'.number_format($paket->harga * ($jumlahHariNew/30),0,',','.'),
			'status' => $status
		];

		echo json_encode($records);
	}

    public function getKetersediaanBooking(Request $request)
	{
		$paket = Paket::where('id', $request->paket_id)->first();

		$end_time = date('H:i:s', strtotime('+'.$paket->jumlah_jam.' minutes', strtotime($request->start_time)));
		$end_date = date('Y-m-d', strtotime('+'.$paket->jumlah_hari.' days', strtotime($request->tanggal_mulai)));
		$hari = numberToDay(date('N', strtotime($request->tanggal_mulai)));

		$cek_booking = Booking::whereRaw('? between tanggal_mulai and tanggal_selesai',[$request->tanggal_mulai])
								->where('lapang_id', $request->lapang_id)
								->whereRaw('? between jam_mulai and jam_selesai',[date('H:i:s', strtotime($request->start_time))])
								->orWhereRaw('? between jam_mulai and jam_selesai',[$end_time])
								->get();

		$cek_jadwal = Jadwal::where('lapang_id', $request->lapang_id)
								->where('hari', $hari)
								->whereRaw('? between jam_mulai and jam_selesai',[date('H:i:s', strtotime($request->start_time)), $end_time])
								->get();

		// $data = [];
		// foreach ($cek_booking as $row) {
		// 	$data[] = [
		// 		'hari' => $row->hari,
		// 		'tanggal_mulai' => $row->tanggal_mulai,
		// 		'tanggal_selesai' => $row->tanggal_selesai,
		// 		'jam_mulai' => $row->jam_mulai,
		// 		'jam_selesai' => $row->jam_selesai
		// 	];
		// }

		// dd($cek_jadwal);

		if (count($cek_booking) > 0 || count($cek_jadwal) > 0) {
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
			$harga = preg_replace('/[Rp.]/', '', $request->total_bayar);
			$jam_mulai = date('H:i:s', strtotime($request->start_time));
			$jam_selesai = date('H:i:s', strtotime($request->end_time));
			$hari = numberToDay($request->hari);
			$jumlah_bulan = $request->jumlah_bulan;

			$booking = Booking::where('user_id', auth()->user()->id)
									->where('paket_id', $paket->id)
									->where('lapang_id', $request->lapang_id)
									->where('tanggal_mulai', $request->tanggal_mulai)
									->where('jam_mulai', $jam_mulai)
									->where('jam_selesai', $jam_selesai)
									->first();

			if (!$booking) {
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
					'harga' => $harga,
					'status' => 0,
					'diskon' => $paket->diskon ? $paket->diskon : NULL,
					'bukti_pembayaran' => NULL,
					'is_member' => true,
				]);

				for ($i=1; $i <= $jumlah_bulan; $i++) { 
					$pembayaran = Pembayaran::create([
						'booking_id' => $booking->id
					]);
				}
			}

			// return redirect()->route('transaksi')->with('msg',['type'=>'success','text'=>'Member berhasil diajukan!']);
		}
		else if($paket->for_use == 'diklat')
		{
			$harga = preg_replace('/[Rp.]/', '', $request->total_bayar);
			$hari = strtolower($request->hari);
			$jam_mulai = date('H:i:s', strtotime($request->start_time));
			$jam_selesai = date('H:i:s', strtotime($request->end_time));
			$jumlah_bulan = $request->jumlah_bulan;

			$jadwal = Jadwal::where('id', $request->jadwal_id)->first();

			$booking = Booking::where('user_id', auth()->user()->id)
									->where('paket_id', $paket->id)
									->where('lapang_id', $jadwal->lapang_id)
									->where('tanggal_mulai', $request->tanggal_mulai)
									->where('jam_mulai', $jam_mulai)
									->where('jam_selesai', $jam_selesai)
									->first();
			if (!$booking) {
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
				
				for ($i=1; $i <= $jumlah_bulan; $i++) { 
					$pembayaran = Pembayaran::create([
						'booking_id' => $booking->id
					]);
				}
			}


			// return redirect()->route('transaksi')->with('msg',['type'=>'success','text'=>'Pelatihan berhasil diajukan!']);
		}
		else
		{
			$jam_mulai = date('H:i:s', strtotime($request->start_time));
			$jam_selesai = date('H:i:s', strtotime($request->end_time));
			$hari = numberToDay(date('N', strtotime($request->tanggal_mulai)));

			$booking = Booking::where('user_id', auth()->user()->id)
									->where('paket_id', $paket->id)
									->where('lapang_id', $request->lapang_id)
									->where('tanggal_mulai', $request->tanggal_mulai)
									->where('jam_mulai', $jam_mulai)
									->where('jam_selesai', $jam_selesai)
									->first();

			if (!$booking) {
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
			}

			// return redirect()->route('transaksi')->with('msg',['type'=>'success','text'=>'Booking berhasil diajukan!']);
		}
		$title = 'Info Pembayaran';
		return view('pages.customer.info_pembayaran', compact('booking','title'));
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

		return redirect()->route('transaksi')->with('msg', ['type' => 'success', 'text' => 'Bukti Pembayaran Berhasil dikirim !']);
	}

	public function delete($id)
	{
		Booking::where('id',$id)->forceDelete();
		return redirect()->back()->with('msg',['type'=>'success','text'=>'Transaksi berhasil dihapus!']);
	}

}
