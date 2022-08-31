<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class EfakturGeneratorController extends Controller
{
    public function generateCsv(request $request, $si, $ba, $bc)
    {

        $user_token = session('user')->api_token;
        $matrixUrl = Config::get('constants.api_url') . '/efakturGenerator';
        $postData = array(
            'si' => base64_decode($si),
            'ba' => base64_decode($ba),
            'bc' => base64_decode($bc),
        );
        $client = new Client();
        $response = $client->request('POST', $matrixUrl, ['json' => $postData]);
        $body = json_decode($response->getBody());
        $data = [
            'si' => $body->si,
            'so' => $body->so,
            'str' => $body->str,
        ];
        return View('efakturGeneratorCsv', $data);
    }
}
