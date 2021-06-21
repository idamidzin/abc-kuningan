<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Paket;
use App\Models\Booking;
use App\Models\User;

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

	public function profile(Request $request)
	{
		$records_aktif = Booking::where('user_id', auth()->user()->id)
							->where('status', 1)
							->get();

		return view('pages.customer.profile', compact('records_aktif'));
	}

	public function editProfile(Request $request)
	{
		return view('pages.customer.edit_profile');
	}

	public function updateProfile(Request $request, $id)
	{
		$user = User::where('id', $id)->first();

		$path_foto = $user->foto;
		$path_kk_ktp = $user->kk_ktp;

		if ($request->hasFile('foto')) {
			$image      = $request->file('foto');
			$fileName   = 'foto_'.auth()->user()->hashid.'.' . $image->getClientOriginalExtension();
			$request->file('foto')->storeAs('/profile',$fileName,'public');
			\File::delete(storage_path('app/public/profile/'.$user->foto));
			$path_foto = $fileName;
		}

		if ($request->hasFile('kk_ktp')) {
			$image      = $request->file('kk_ktp');
			$fileName   = 'kk_ktp_'.auth()->user()->hashid.'.' . $image->getClientOriginalExtension();
			$request->file('kk_ktp')->storeAs('/profile',$fileName,'public');
			\File::delete(storage_path('app/public/profile/'.$user->kk_ktp));
			$path_kk_ktp = $fileName;
		}

		$passwordNew = $request->password;

		if ($request->has('password')) {
			$passwordNew = bcrypt($request->password);
		}

		$user->nama_lengkap = $request->nama;
		$user->username = $request->username;
		$user->password = $passwordNew;
		$user->email = $request->email;
		$user->alamat = $request->alamat;
		$user->kk_ktp = $path_kk_ktp;
		$user->nohp = $request->nohp;
		$user->jenis_kelamin = $request->jenis_kelamin;
		$user->tanggal_lahir = $request->tanggal_lahir;
		$user->foto = $path_foto;
		$user->update();

		return redirect()->back()->with('msg',['type'=>'success','text'=>'Profile berhasil diperbaharui!']);
	}
}
