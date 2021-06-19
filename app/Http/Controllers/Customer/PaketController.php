<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Paket;
use Auth;

class PaketController extends Controller
{
	public function index(Request $request)
	{
		$for_use = $request->get('for_use');

		$records = Paket::query();

		if ($for_use == 'member') {
			$pakets = $records->where('for_use', 'member')->get();
			$title = 'Paket Member';
		}else if($for_use == 'non-member'){
			$pakets = $records->where('for_use', 'non-member')->get();
			$title = 'Paket Booking';
		}else if($for_use == 'diklat'){
			$pakets = $records->where('for_use', 'diklat')->get();
			$title = 'Paket Booking';
		}else{
			$title = 'Semua Paket';
			$pakets = $records->get();
		}

		$member_count = Paket::where('for_use', 'member')->count();
		$non_member_count = Paket::where('for_use', 'non-member')->count();
		$diklat_count = Paket::where('for_use', 'diklat')->count();


		$kategori = [];
		if (auth()->user() != NULL) 
		{
			if (auth()->user()->role == 2)  {
				return view('pages.customer.paket', compact('title','kategori','pakets','member_count','non_member_count','diklat_count'));
			}else{
				Auth::guard('web')->logout();
				return redirect()->route('home');
			}
		}

		return view('pages.customer.paket', compact('title','kategori','pakets','member_count','non_member_count','diklat_count'));
	}

	public function paketDetail(Request $request, $id)
	{
		$title = 'Rincian Paket';
		$paket = Paket::where('id', $id)->first();
		return view('pages.customer.detail_paket', compact('paket', 'title'));
	}

}
