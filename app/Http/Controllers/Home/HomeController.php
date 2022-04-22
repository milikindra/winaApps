<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        try {
            $data = [
                'page' => 'home',
                'parent_page' => 'home',
                'title' => 'Home',
            ];
            return View('home', $data);
        } catch (\Exception $e) {
            Log::debug($request->path() . " | " . $message . " | " . print_r($_POST, TRUE));

            return abort(500);
        }
    }
}
