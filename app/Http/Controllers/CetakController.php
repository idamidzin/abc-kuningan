<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class CetakController extends Controller
{
    public function index(Request $request)
    {
    	$produk = Produk::where('status_cetak', 0)->get();
    	return view('pages.cetak.index', compact('produk'));
    }

    public function get(Request $request)
	{
		$records = Produk::where('status_cetak', $request->status_cetak)->get();

		return response()->json(['data'=>$records->map(function($row){
			return [
				'hashid'=>$row->hashid,
				'id_produk'=>$row->id_produk,
				'nama' => $row->nama,
				'harga' => 'Rp.'.number_format($row->harga,0,',','.'),
				'deskripsi' => $row->deskripsi,
				'foto' => $row->foto,
				'qr_code' => $row->qr_code,
				'status_cetak' => $row->status_cetak,
				];
			})
		]);
	}

	public function cetakSemua(Request $request)
	{
		$records = Produk::where('status_cetak', $request->status)->get();

		Produk::where('status_cetak', $request->status)->update([
			'status_cetak' => 1
		]);

		if ($records->count() <= 0) {
			return back()->with('msg',['type'=>'danger','text'=>'Data QR-Code tidak ditemukan!'])->withInput();
		}

		$pdf = \PDF::loadView('pages.cetak.cetak_semua', compact('records'));
  
        return $pdf->download('cetak.pdf');
	}

	public function cetakOne(Request $request, $id)
	{
		$produk = Produk::where('id', $id)->first();

		Produk::where('id', $id)->update([
			'status_cetak' => 1
		]);

		$pdf = \PDF::loadView('pages.cetak.cetak_one', compact('produk'));
  
        return $pdf->download('cetak.pdf');
	}

}
