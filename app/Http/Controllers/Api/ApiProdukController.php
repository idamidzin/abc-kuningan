<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ApiProdukController extends Controller
{
	public function getProduk()
	{
		$produk = Produk::all();

		$records = [];
		foreach ($produk as $row) {
			$records[] = [
				'id' => $row->id,
				'nama' => $row->nama,
				'deskripsi' => $row->deskripsi,
				'harga' => $row->harga,
				'stok' => $row->stok,
				'foto' => asset('storage/produk/'.$row->foto)
			];
		}

		return $this->successJSON([
			'produk' => $records
		]);
	}
}
