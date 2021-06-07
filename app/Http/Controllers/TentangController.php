<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tentang;

class TentangController extends Controller
{
    public function index()
    {
    	$tentang = Tentang::where('id', 1)->first();
    	return view('pages.tentang.index', compact('tentang'));
    }

    public function update(Request $request, $id)
    {
    	$tentang = Tentang::where('id', $id)->first();

    	$path_foto = $tentang->gambar;

		if ($request->hasFile('gambar')) {
			$image      = $request->file('gambar');
			$fileName   = 'tentang_'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('gambar')->storeAs('/tentang',$fileName,'public');
			\File::delete(storage_path('app/public/tentang/'.$tentang->gambar));
			$path_foto = $fileName;
		}

		$tentang->title = $request->title;
		$tentang->keterangan = $request->keterangan;
		$tentang->gambar = $path_foto;
		$tentang->update();

		return redirect()->route('tentang.index')->with('msg',['type'=>'success','text'=>'Tentang berhasil diubah!']);
    }
}
