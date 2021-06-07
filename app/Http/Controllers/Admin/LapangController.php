<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapang;

class LapangController extends Controller
{
	public function index(Request $request)
	{
		$is_trash = $request->get('status') == 'trash';

		$records = Lapang::query();
		$lapang_count = $records->count();

		$trashes = Lapang::onlyTrashed()->orderBy('deleted_at','desc');
		$trash_count = $trashes->count();

		$records = $is_trash ? $trashes->orderBy('id', 'DESC')->get() : $records->orderBy('id', 'DESC')->get();

		return view('pages.admin.lapang.index',compact('records','is_trash','lapang_count','trash_count'));
	}

	public function create(){
		return view('pages.admin.lapang.create');
	}

	public function store(Request $request)
	{
		$path_foto = null;

		if ($request->hasFile('foto')) {
			$image      = $request->file('foto');
			$fileName   = 'lapang_'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('foto')->storeAs('/lapang',$fileName,'public');
			$path_foto = $fileName;
		}

		Lapang::create([
			'nama'=>$request->nama,
			'keterangan' => $request->keterangan,
			'foto' => $path_foto
		]);

		return redirect()->route('admin.lapang.index')->with('msg',['type'=>'success','text'=>'Lapang berhasil ditambahkan!']);
	}

	public function edit($id)
	{
		$lapang = Lapang::where('id', $id)->first();

		return view('pages.admin.lapang.edit', compact('lapang'));
	}

	public function update(Request $request, $id)
	{
		$lapang = Lapang::where('id',$id)->first();

		$path_foto = $lapang->foto;

		if ($request->hasFile('foto')) {
			$image      = $request->file('foto');
			$fileName   = 'lapang_'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('foto')->storeAs('/lapang',$fileName,'public');
			\File::delete(storage_path('app/public/lapang/'.$lapang->foto));
			$path_foto = $fileName;
		}

		if (!$lapang) {
			return back()->with('msg',['type'=>'danger','text'=>'Lapang tidak ditemukan!'])->withInput();
		}

		$lapang->nama = $request->nama;
		$lapang->keterangan = $request->keterangan;
		$lapang->foto = $path_foto;
		$lapang->update();

		return redirect()->route('admin.lapang.index')->with('msg',['type'=>'success','text'=>'Lapang berhasil diperbaharui!']);
	}

	public function delete($id)
	{
		Lapang::where('id',$id)->delete();
		return redirect()->route('admin.lapang.index')->with('msg',['type'=>'success','text'=>'Lapang berhasil dihapus!']);
	}

	public function destroy($id)
	{
		Lapang::where('id',$id)->forceDelete();
		return redirect()->route('admin.lapang.index')->with('msg',['type'=>'success','text'=>'Lapang berhasil dihapus!']);
	}

	public function restore($id)
	{
		Lapang::where('id',$id)->restore();
		return redirect()->route('admin.lapang.index')->with('msg',['type'=>'success','text'=>'Lapang berhasil direstore!']);
	}
}
