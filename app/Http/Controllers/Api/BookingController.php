<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Produk;
use Carbon\Carbon;

class BookingController extends Controller
{
	public function cekKeranjang()
	{
		$booking = Booking::where('user_id', auth()->user()->id)->where('status', 0)->first();

		if (!$booking) {
			return $this->errorJSON("Keranjang kosong !",404);
		}

		$booking_details = [];
		$total = [];
		foreach ($booking->BookingDetail as $val) {
			$booking_details[] = [
				'id' => "".$val->id,
				'nama_produk' => $val->Produk->nama,
				'harga' => $val->harga,
				'jumlah' => $val->jumlah
			];
			$total[] = $val->jumlah*$val->harga;
		}

		$bookings = [
			'id' => "".$booking->id,
			'kode_booking' => $booking->kode_booking,
			'total_harga' => "".array_sum($total),
			'details' => $booking_details
		];
		
		return $this->successJSON([
			'keranjang' => $bookings
		]);
	}

	public function addKeranjang(Request $request)
	{
		$booking = Booking::where('user_id', auth()->user()->id)->where('status', 0)->first();
		$produk = Produk::where('id', $request->produk_id)->first();

		if (!$produk) {
			return $this->errorJSON("Produk tidak ditemukan",404);
		}
		
		$total = $produk->harga*$request->jumlah;

		if ($booking)
		{
			$total_harga_new = $total+$booking->total_harga;
			$booking->total_harga = $total_harga_new;
			$booking->update();

			$booking_detail = BookingDetail::where('booking_id', $booking->id)->where('produk_id', $produk->id)->first();

			if ($booking_detail)
			{
				$booking_detail->jumlah = $booking_detail->jumlah+$request->jumlah;
				$booking_detail->update();
			}
			else
			{
				BookingDetail::create([
					'booking_id' => $booking->id,
					'produk_id' => $produk->id,
					'harga' => $produk->harga,
					'jumlah' => $request->jumlah
				]);
			}
		}
		else
		{
			$newKodeBooking = 'KNGOR00001';

			$lastBooking = Booking::orderBy('id','desc')->withTrashed()->first();

			if ($lastBooking)
			{
				$lastKodeBooking = $lastBooking->kode_booking;
				$intKodeBooking = (int) substr($lastKodeBooking,6);

				$nextNumber = $intKodeBooking + 1;
				$newKodeBooking = "KNGOR".sprintf("%05d", $nextNumber);
			}
			
			$bookingNew = Booking::create([
				'kode_booking' => $newKodeBooking,
				'user_id' => auth()->user()->id,
				'total_harga' => $total,
				'status' => 0,
			]);

			BookingDetail::create([
				'booking_id' => $bookingNew->id,
				'produk_id' => $produk->id,
				'harga' => $produk->harga,
				'jumlah' => $request->jumlah
			]);

		}
		return $this->successJSON();
	}

	public function cekHargaJumlah(Request $request)
	{
		
	}

	public function cekHargaHarian(Request $request)
	{
		$booking = Booking::where('id', $request->id)->first();

		if (!$booking) {
			return $this->errorJSON("Keranjang tidak ditemukan",404);
		}

		if (strtotime($request->tanggal_mulai) > strtotime($request->tanggal_selesai)) {
			return $this->errorJSON("Tanggal selesai lebih kecil dari tanggal mulai!",404);
		}

		$mulai = Carbon::parse(date('Y-m-d', strtotime($request->tanggal_mulai)));
		$selesai = Carbon::parse(date('Y-m-d', strtotime($request->tanggal_selesai)));

		$jumlah_hari = $mulai->diffInDays($selesai)+1;

		$harga_perhari = $booking->total_harga*$jumlah_hari;

		return $this->successJSON([
			'jumlah_hari' => $jumlah_hari,
			'harga_perhari' => $harga_perhari
		]);
	}

	public function setBooking(Request $request)
	{
		$booking = Booking::where('id', $request->id)->first();

		if (!$booking) {
			return $this->errorJSON("Booking tidak ditemukan!",404);
		}

		$mulai = Carbon::parse(date('Y-m-d', strtotime($request->tanggal_mulai)));
		$selesai = Carbon::parse(date('Y-m-d', strtotime($request->tanggal_selesai)));

		$jumlah_hari = $mulai->diffInDays($selesai)+1;

		$harga_perhari = $booking->total_harga*$jumlah_hari;

		$booking->status = 1;
		$booking->tanggal_mulai = $request->tanggal_mulai;
		$booking->tanggal_selesai = $request->tanggal_selesai;
		$booking->jumlah_hari = $jumlah_hari;
		$booking->update();

		return $this->successJSON();
	}
}
