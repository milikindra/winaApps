<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Employee;


class EfakturController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "M12";

    public function byDate(request $request, $dates)
    {
        try {
            $user_token = session('user')->api_token;
            $post_data = [
                'user' => session('user')->username,
                'dates' => $dates,
            ];

            $url = Config::get('constants.api_url') . '/efaktur/getByDate';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            return json_encode($body);
        } catch (\Exception $e) {
            Log::debug($request->path());
            Log::debug($e);
            return abort(500);
        }
    }
}
