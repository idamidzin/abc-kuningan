<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (!auth()->check()) 
        {
            return redirect('/login');
        }

        if ($user != NULL) {
            if (auth()->user()->verifikasi == "0") {
                return redirect()->route('home')->with('msg', [
                    'type'=>'danger',
                    'for'=>'verifikasi',
                    'text'=>'Mohon Maaf, silahkan untuk melakukan verifikasi akun untuk melanjutkan aktivitas di platform ini, terimakasih. <a href="daftar-verifikasi") }}">Verifikasi Sekarang</a>'
                ]);
            }else{
                return $next($request);
            }
        }else{
            return redirect()->route('dashboard.index')->with('msg', ['type'=>'danger','text'=>'Access Denied']);
        }

        return abort('403');
    }
}
