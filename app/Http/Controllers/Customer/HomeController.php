<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Paket;

class HomeController extends Controller
{
	public function index(Request $request)
	{
		$pakets=  Paket::limit(4)->orderBy('id', 'DESC')->get();
		if (auth()->user() != NULL) 
		{
			if (auth()->user()->role == 2)  {
				return view('pages.customer.home', compact('pakets'));
			}else{
				Auth::guard('web')->logout();
				return redirect()->route('home');
			}
		}

		return view('pages.customer.home', compact('pakets'));
	}
}
