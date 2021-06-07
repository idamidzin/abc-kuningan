<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Str;
use QRCode;
use LaravelQRCode\QRCodeFactory;

class ProdukController extends Controller
{
	public function index(Request $request)
	{
		$is_trash = $request->get('status') == 'trash';

		$records = Produk::query();
		$produk_count = $records->count();

		$trashes = Produk::onlyTrashed()->orderBy('deleted_at','desc');
		$trash_count = $trashes->count();

		$records = $is_trash ? $trashes->orderBy('id', 'DESC')->get() : $records->orderBy('id', 'DESC')->get();

		return view('pages.produk.index',compact('records','is_trash','produk_count','trash_count'));
	}

	public function create(){
		return view('pages.produk.create');
	}

	public function store(Request $request)
	{
		// dd($request->all());
		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		$newIdProduk = 'KO0001';

		$lastProduk = Produk::orderBy('id','desc')->withTrashed()->first();

		if ($lastProduk)
		{
			$lastIdProduk = $lastProduk->id_produk;
			$intIdProduk = (int) substr($lastIdProduk,8);
			// dd($intIdProduk);
			$nextNumber = $intIdProduk + 1;
            // dd($nextNumber);
			$newIdProduk = "KO".sprintf("%04d", $nextNumber);
		}

		$encryptedCode = base64_encode($newIdProduk);

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

		Produk::create([
			'nama'=>$request->nama,
			'harga' => $harga,
			'deskripsi' => $request->deskripsi,
			'foto' => $path_foto,
            'stok' => $request->stok
		]);

		return redirect()->route('produk.index')->with('msg',['type'=>'success','text'=>'Produk berhasil ditambahkan!']);
	}

	public function edit($id)
	{
		$produk = Produk::where('id', $id)->first();

		return view('pages.produk.edit', compact('produk'));
	}

	public function update(Request $request, $id)
	{
		$produk = Produk::where('id',$id)->first();

		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		$path_foto = $produk->foto;

		if ($request->hasFile('foto')) {
			$image      = $request->file('foto');
			$fileName   = 'produk_'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('foto')->storeAs('/produk',$fileName,'public');
			\File::delete(storage_path('app/public/produk/'.$produk->foto));
			$path_foto = $fileName;
		}

		$produk->nama = $request->nama;
		$produk->harga = $harga;
		$produk->deskripsi = $request->deskripsi;
		$produk->foto = $path_foto;
		$produk->stok = $request->stok;
		$produk->update();

		return redirect()->route('produk.index')->with('msg',['type'=>'success','text'=>'Produk berhasil diperbaharui!']);
	}

	public function delete($id)
	{
		Produk::where('id',$id)->delete();
		return redirect()->route('produk.index')->with('msg',['type'=>'success','text'=>'Produk berhasil dihapus!']);
	}

	public function destroy($id)
	{
		Produk::where('id',$id)->forceDelete();
		return redirect()->route('produk.index')->with('msg',['type'=>'success','text'=>'Produk berhasil dihapus!']);
	}

	public function restore($id)
	{
		Produk::where('id',$id)->restore();
		return redirect()->route('produk.index')->with('msg',['type'=>'success','text'=>'Produk berhasil direstore!']);
	}
}
