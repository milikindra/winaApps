<?php

namespace App\Http\Middleware;

use Closure;

class UserMatrixMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module_function_id)
    {
        $module_function_id_array = explode(';', $module_function_id);
        if (!session('user')) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized user!'], 401);
            }
            return redirect('/');
        }
        // dd(session()->all());
        $user_access = session('user')->user_access;

        $arrAccess = [];
        foreach ($user_access as $u) {
            $arrAccess[] = $u->module_function_id;
        }
        // dd($arrAccess);
        $ada = false;
        foreach ($module_function_id_array as $moduleID) {
            if (!in_array($moduleID, $arrAccess)) {
                if (!$ada)
                    $ada = false;
            } else {
                $ada = true;
            }
        }
        if (!$ada) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized user.'], 401);
            }
            abort(401);
        }
        return $next($request);
    }
}
