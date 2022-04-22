<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
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
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        $password = $request->input('password');
        $username = $request->input('username');
        $user = User::where('username', $username)->first();

        if (!isset($user)) {
            $message = 'User tidak ditemukan';
            Log::debug($request->path() . " | " . $message . " | " . print_r($_POST, TRUE));
            $response = array(
                'result' => FALSE,
                'message' => $message
            );
            return redirect(route('login'))->withInput($request->except('passwodr'))->with('error', __('' . $message));
        } else {
            if ($user->status == 0) {
                $message = 'Akun belum aktif/dihapus';
                Log::debug($request->path() . " | " . $message . " | " . print_r($_POST, TRUE));
                $response = array(
                    'result' => FALSE,
                    'message' => $message
                );
            } else {
                $checkPassword = Hash::check($password, $user->password);
                if ($checkPassword) {
                    // $user->is_login = '1';
                    // $user->save();
                    $data = User::getLogin($username);
                    $test  = json_encode(array('id' => 'test'));
                    session([
                        'user' => $data,
                        'user_test' => $test
                    ]);

                    $message = "User '$username' successfully login";
                    $response = array(
                        'result' => TRUE,
                        'message' => $message,
                        'data' => $data,
                    );
                    if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                        $request->session()->regenerate();
                        return redirect()->intended('home');
                    }
                } else {
                    $message = 'Password yang anda masukkan salah';
                    Log::debug($request->path() . " | " . $message . " | " . print_r($_POST, TRUE));
                    $response = array(
                        'result' => FALSE,
                        'message' => $message
                    );
                    return redirect(route('login'))->withInput($request->except('passwodr'))->with('error', __('' . $message));
                }
            }
        }
    }

    public function logout(Request $request)
    {
        // jika is_login mau di aktifkan gunakan code berikut
        // $username = session('user')->username;
        // $user = User::where('username', $username)->first();
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
