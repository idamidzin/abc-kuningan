<?php

namespace App\Http\Middleware;

use Closure;

class ApiAdminAuthentication
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
        $token = $request->bearerToken();
        if (!empty($token)) 
        {
            $user = \App\Models\User::where('api_token', $token)->where('role', 1)->first();
            if ($user) 
            {
                auth()->login($user);
                return $next($request);
            }
        }
        return response()->json([
            'message' => 'Unauthenticated',
            'status_code'=>403
        ], 403);
    }
}
