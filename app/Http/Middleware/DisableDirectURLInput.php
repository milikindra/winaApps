<?php

namespace App\Http\Middleware;

use Closure;

class DisableDirectURLInput
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
        $referer = $request->header('referer');
        if (empty($referer)) {
            abort(400);
        }
        return $next($request);
    }
}
