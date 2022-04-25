<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class AuthApiMiddleware
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
        // dd(session()->all());
        $maintenance = '0';
        if ($maintenance == '1') {
            session()->flush();

            return redirect(route('login.index'))->with('error', 'Aplikasi sedang Maintenance');
        }
        if (!session('user')) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized user'], 401);
            }
            return redirect('/');
        } else {
        }
        return $next($request);
    }
}
