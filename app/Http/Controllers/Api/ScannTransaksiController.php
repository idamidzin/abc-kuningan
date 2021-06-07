<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\ScannTransaksi;

class ScannTransaksiController extends Controller
{
    public function scann(Request $request)
    {
    	event(new ScannTransaksi($request->kode_booking));

    	return $this->successJSON();
    }
}
