<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout() {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user != null) {
            if (Auth::attempt(['username'=>$request->username,'password'=>$request->password])) 
            {
                return redirect()->route('admin.dashboard');
            }
            return back()->with('msg',['type'=>'danger','text'=>'Username dan Password Tidak Cocok!'])->withInput();
        }else{
            return back()->with('msg',['type'=>'danger','text'=>'Username dan Password Tidak Cocok!'])->withInput();
        }
        
    }
}
