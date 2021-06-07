<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
	public function index(Request $request)
	{
		$is_trash = $request->get('status') == 'trash';

		$records = Kategori::query();
		$kategori_count = $records->count();

		$trashes = Kategori::onlyTrashed()->orderBy('deleted_at','desc');
		$trash_count = $trashes->count();

		$records = $is_trash ? $trashes->orderBy('id', 'DESC')->get() : $records->orderBy('id', 'DESC')->get();

		return view('pages.admin.kategori.index',compact('records','is_trash','kategori_count','trash_count'));
	}

	public function create(){
		return view('pages.admin.kategori.create');
	}

	public function store(Request $request)
	{
		Kategori::create([
			'nama'=>$request->nama,
			'usia_mulai' => $request->usia_mulai,
			'usia_sampai' => $request->usia_sampai,
		]);

		return redirect()->route('admin.kategori.index')->with('msg',['type'=>'success','text'=>'Kategori berhasil ditambahkan!']);
	}

	public function edit($id)
	{
		$kategori = Kategori::where('id', $id)->first();

		return view('pages.admin.kategori.edit', compact('kategori'));
	}

	public function update(Request $request, $id)
	{
		$kategori = Kategori::where('id',$id)->first();

		if (!$kategori) {
			return back()->with('msg',['type'=>'danger','text'=>'Kategori tidak ditemukan!'])->withInput();
		}

		$kategori->nama = $request->nama;
		$kategori->usia_mulai = $request->usia_mulai;
		$kategori->usia_sampai = $request->usia_sampai;
		$kategori->update();

		return redirect()->route('admin.kategori.index')->with('msg',['type'=>'success','text'=>'Kategori berhasil diperbaharui!']);
	}

	public function delete($id)
	{
		Kategori::where('id',$id)->delete();
		return redirect()->route('admin.kategori.index')->with('msg',['type'=>'success','text'=>'Kategori berhasil dihapus!']);
	}

	public function destroy($id)
	{
		Kategori::where('id',$id)->forceDelete();
		return redirect()->route('admin.kategori.index')->with('msg',['type'=>'success','text'=>'Kategori berhasil dihapus!']);
	}

	public function restore($id)
	{
		Kategori::where('id',$id)->restore();
		return redirect()->route('admin.kategori.index')->with('msg',['type'=>'success','text'=>'Kategori berhasil direstore!']);
	}
}
