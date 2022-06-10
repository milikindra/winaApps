<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use GuzzleHttp\Client;
use App\Models\User;
use validator;
use DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        session()->flush();
        return View('login');
    }

    public function action(Request $request)
    {
        $messages = [
            'required' => ':Attribute tidak boleh dikosongi',
            'same' => ':Attribute harus sama dengan :other'
        ];

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $password = $request->input('password');
        $email = $request->input('email');

        $loginUrl = config('constants.api_url') . '/login';
        $post_data = [
            'email' => $email,
            'password' => $password,
        ];
        $client = new Client();
        $response = $client->request('POST', $loginUrl, [
            'json' => $post_data,
            'http_errors' => false
        ]);
        $body = json_decode($response->getBody()->getContents());
        App::setLocale('id');
        if ($response->getStatusCode() == 422) {
            //then there should be some validation JSON here;
            $errors = json_decode($response->getBody()->getContents());
            return redirect()->back()->withInput($request->except('password'))->with('error', __('messages.Invalid password'));
        }
        if ($body->result) {
            session([
                'user' => $body->data,
            ]);
            App::setLocale('id');
            return redirect(route('home'));
        } else {
            $message = 'gagal login';
            Log::debug($request->path() . " | " . $message . " | " . print_r($_POST, TRUE));
            $response = array(
                'result' => FALSE,
                'message' => $message
            );
            return redirect(route('login'))->withInput($request->except('password'))->with('error', __('' . $message));
        }
    }

    public function logout(Request $request)
    {
        // jika is_login mau di aktifkan gunakan code berikut
        // $email = session('user')->email;
        // $user = User::where('email', $email)->first();
        // $user->is_login = '1';
        // $user->save();

        session()->flush();
        return redirect(route('login'));
    }

    public function forget()
    {
    }

    public function newPassword()
    {
    }

    public function newPasswordSave()
    {
    }
}
