<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Kategori;

class PelatihanController extends Controller
{
	public function index(Request $request)
	{
		$for_use = $request->get('for_use');

		$records = Paket::query();

		$title    = 'Pelatihan';

		$pakets = $records->where('for_use', 'diklat')->get();
		
		$kategori = [];
		if (auth()->user() != NULL) 
		{
			if (auth()->user()->role == 2)  {
				return view('pages.customer.pelatihan', compact('title', 'kategori', 'pakets'));
			}else{
				Auth::guard('web')->logout();
				return redirect()->route('home');
			}
		}

		return view('pages.customer.pelatihan', compact('title', 'kategori', 'pakets'));
	}
}
