<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Tentang;
use App\Models\Petunjuk;

class ApiGaleriController extends Controller
{
    public function getGaleri()
    {
        $galeri = Produk::get();

        $records = [];
        foreach ($galeri as $row) {
            $records [] = [
                'id' => $row->id,
                'id_produk' => $row->id_produk,
                'nama' => $row->nama,
                'harga' => 'Rp.'.number_format($row->harga, 0,',','.'),
                'deskripsi' => $row->deskripsi,
                'foto' => $row->foto ? asset('storage/produk/'.$row->foto) : ""
            ];
        }

        return $this->successJSON([
            'galeri' => $records
        ]);
    }

    public function getGaleriDetail(Request $request)
    {
        $galeri = Produk::where('id', $request->id)->first();

        if ($galeri == null) {
            return $this->errorJSON("Produk tidak ditemukan", 403);
        }

        return $this->successJSON([
            'galeri_detail' => [
                'id' => $galeri->id,
                'nama' => $galeri->nama,
                'harga' => 'Rp.'.number_format($galeri->harga, 0,',','.'),
                'deskripsi' => $galeri->deskripsi,
                'foto' => $galeri->foto ? asset('storage/produk/'.$galeri->foto) : ""
            ]
        ]);
    }

    public function getTentang()
    {
        $records = Tentang::where('id', 1)->first();

        return $this->successJSON([
            'tentang' => [
                'title' => $records->title,
                'gambar' => asset('storage/tentang/'.$records->gambar),
                'keterangan' => $records->keterangan,
            ]
        ]);
    }

    public function getPetunjuk()
    {
        $petunjuk = Petunjuk::get();

        $records = [];

        foreach ($petunjuk as $row) {
            $records[] = [
                'nama' => $row->nama
            ];
        }

        return $this->successJSON([
            'petunjuk' => $records
        ]);
    }
}
