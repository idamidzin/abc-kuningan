<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
	public function index(Request $request)
	{
		$is_trash = $request->get('status') == 'trash';

		$records = Paket::query();
		$paket_count = $records->count();

		$trashes = Paket::onlyTrashed()->orderBy('deleted_at','desc');
		$trash_count = $trashes->count();

		$records = $is_trash ? $trashes->orderBy('id', 'DESC')->get() : $records->orderBy('id', 'DESC')->get();

		return view('pages.admin.paket.index',compact('records','is_trash','paket_count','trash_count'));
	}

	public function create(){
		return view('pages.admin.paket.create');
	}

	public function store(Request $request)
	{
		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		Paket::create([
			'nama'=>$request->nama,
			'jumlah_jam' => $request->jumlah_jam,
			'jumlah_hari' => $request->jumlah_hari,
			'harga' => $harga,
			'for_use' => $request->target,
			'diskon' => $request->diskon
		]);

		return redirect()->route('admin.paket.index')->with('msg',['type'=>'success','text'=>'Paket berhasil ditambahkan!']);
	}

	public function edit($id)
	{
		$paket = Paket::where('id', $id)->first();

		return view('pages.admin.paket.edit', compact('paket'));
	}

	public function update(Request $request, $id)
	{
		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		$paket = Paket::where('id',$id)->first();

		if (!$paket) {
			return back()->with('msg',['type'=>'danger','text'=>'Paket tidak ditemukan!'])->withInput();
		}

		$paket->nama = $request->nama;
		$paket->jumlah_jam = $request->jumlah_jam;
		$paket->jumlah_hari = $request->jumlah_hari;
		$paket->harga = $harga;
		$paket->diskon = $request->diskon;
		$paket->for_use = $request->target;
		$paket->update();

		return redirect()->route('admin.paket.index')->with('msg',['type'=>'success','text'=>'Paket berhasil diperbaharui!']);
	}

	public function delete($id)
	{
		Paket::where('id',$id)->delete();
		return redirect()->route('admin.paket.index')->with('msg',['type'=>'success','text'=>'Paket berhasil dihapus!']);
	}

	public function destroy($id)
	{
		Paket::where('id',$id)->forceDelete();
		return redirect()->route('admin.paket.index')->with('msg',['type'=>'success','text'=>'Paket berhasil dihapus!']);
	}

	public function restore($id)
	{
		Paket::where('id',$id)->restore();
		return redirect()->route('admin.paket.index')->with('msg',['type'=>'success','text'=>'Paket berhasil direstore!']);
	}
}