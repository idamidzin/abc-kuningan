<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
	{
		$user = User::where('username', $request->username)
					->first();
					
		if (!$user) 
		{
			return $this->errorJSON("Username tidak ditemukan!",404);
		}

		if (\Hash::check($request->password,$user->password) == false) 
		{
			return $this->errorJSON("Password salah!",404);
		}

		$user->api_token = \Str::random(60);
		$user->save();

		return $this->successJSON([
			'user'=>[
				'hashid'=>$user->hashid,
				'username'=>$user->username,
				'nama'=>$user->nama,
				'token'=>$user->api_token,
				'role' => $user->role
			]
		]);
	}

	public function logout(Request $request)
	{
		User::where('api_token', $request->bearerToken())
					->update([
						'api_token'=>NULL
					]);
		return $this->successJSON();
	}

	public function verifyDevice(Request $request)
	{
		$version_app = ENV('APP_MOBILE_VERSION','V1');
		$link = ENV('APP_MOBILE_LINK',asset(""));

		$version = $request->version;
		if ($version != $version_app)
		{
			return $this->successJSON(['version'=>"Gunakan versi terbaru $version_app dengan cara download di website siakad.smabu-kng.sch.id",'auth'=>'','link'=>$link]);
		}
		$token = $request->bearerToken();
		if (empty($token)) 
		{
			return $this->successJSON(['version'=>'ok','auth'=>'','link'=>'']);
		}

		$user = User::where('api_token', $token)->first();
        if ($user) 
        {
        	return $this->successJSON(['version'=>'ok','auth'=>'ok','link'=>'']);
        }
        return $this->successJSON(['version'=>'ok','auth'=>'exp','link'=>'']);
	}
}
