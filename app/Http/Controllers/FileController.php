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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class FileController extends Controller
{
    public function getFile(request $request, $path)
    {
        // dd(base64_decode($path));
        // $file = Storage::disk('local')->get(base64_decode($path));
        // $type = File::mimeType(Storage::path(base64_decode($path)));
        // $myFile = pathinfo(Storage::path(base64_decode($path)));
        // $fileName = $myFile['basename'];

        // return (new Response($file, 200))
        //     ->header('Content-Type', $type);

        return Storage::download(base64_decode($path));
    }
}
