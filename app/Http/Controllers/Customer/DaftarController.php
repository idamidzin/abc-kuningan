<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class DaftarController extends Controller
{
	public function index()
	{
		$title = 'Pendaftaran Akun';
		return view('auth.daftar', compact('title'));
	}

	public function daftar(Request $request)
	{
		$user = User::where('email', $request->email)->orWhere('username', $request->username)->first();

		if ($user != null)
		{
			if ($user->username == $request->username) {
				return back()->with('msg',['type'=>'danger','text'=>'Username sudah terpakai!'])->withInput();
			}
			if ($user->email == $request->email) {
				return back()->with('msg',['type'=>'danger','text'=>'Email sudah pernah terdaftar!'])->withInput();
			}
		}
		else
		{
			$user = User::create([
				'role' => 2,
				'nama_lengkap' => $request->nama_lengkap,
				'username' => $request->username,
				'password' => bcrypt($request->password),
				'email' => $request->email,
				'alamat' => NULL,
				'kk_ktp' => NULL,
				'nohp' => $request->nohp,
				'jenis_kelamin' => NULL,
				'tanggal_lahir' => NULL,
				'is_status' => 1,
				'kategori_id' => NULL,
				'foto' => NULL,
				'verifikasi' => 0
			]);

			return redirect()->route('login.customer')->with('msg',['type'=>'success','text'=>'Pendaftaran Berhasil']);
		}
	}


	public function kirimEmail()
	{
		$to_name = auth()->user()->nama_lengkap;
		$to_email = auth()->user()->email;
		$data = array(
			'name'=> auth()->user()->nama_lengkap, 
			'id' => auth()->user()->hashid, 
			'username' => auth()->user()->username
		);

		\Mail::send('auth.verifikasi', $data, function($message) use ($to_name, $to_email) {
			$message->to($to_email, $to_name)->subject('Verifikasi Akun Anrimusthi Badminton Centre Kuningan');
			$message->from('artostechnopay@gmail.com','Anrimusthi Badminton Centre Kuningan');
		});

		return back()->with('msg',['type'=>'warning','text'=>'Verifikasi telah dikirim, Silahkan Cek '.$to_email.' untuk verifikasi, Kirim Ulang <a href="daftar-verifikasi") }}">Klik Disini</a>']);
	}

	public function verifikasi(Request $request)
	{
		$user = User::where('id', $request->id)->first();

		$user->verifikasi = 1;
		$user->update();

		return redirect()->route('home')->with('msg',['type'=>'success','text'=>'Verifikasi Email Berhasil!']);
	}

	public function kirimUlang(Request $request)
	{
		$to_name = auth()->user()->nama_lengkap;
		$to_email = auth()->user()->email;
		$data = array(
			'name'=> auth()->user()->nama_lengkap, 
			'id' => auth()->user()->hashid, 
			'username' => auth()->user()->username
		);

		\Mail::send('auth.verifikasi', $data, function($message) use ($to_name, $to_email) {
			$message->to($to_email, $to_name)->subject('Verifikasi Akun Anrimusthi Badminton Centre Kuningan');
			$message->from('artostechnopay@gmail.com','Anrimusthi Badminton Centre Kuningan');
		});

		return back()->with('msg',['type'=>'warning','text'=>'Verifikasi dikirim kembali, Silahkan Cek '.$request->email.' untuk verifikasi ! Kirim Ulang <a href="register/kirimulang") }}">Klik Disini </a>']);
	}
}