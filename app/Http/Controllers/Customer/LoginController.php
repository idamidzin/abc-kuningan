<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
	use AuthenticatesUsers;

	protected $redirectTo = '/home';

	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	public function showLoginForm(){
		$title = 'Halaman Masuk';
		return view('auth.login_customer', compact('title'));
	}

	public function logout() {
		Auth::guard('web')->logout();
		return redirect()->route('home');
	}

	public function login(Request $request)
	{
		$user = User::where('username', $request->username)->first();
		if ($user != null) {	
			if (Auth::attempt(['username'=>$request->username,'password'=>$request->password])) 
			{
				return redirect()->route('home');
			}
			return back()->with('msg',['type'=>'danger','text'=>'Username dan Password Tidak Cocok!'])->withInput();
		}else{
			return back()->with('msg',['type'=>'danger','text'=>'Username dan Password Tidak Cocok!'])->withInput();
		}
	}
}
