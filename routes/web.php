<?php

use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Master\EmployeeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });


Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [LoginController::class, 'index']);
    Route::post('/', [LoginController::class, 'index']);

    Route::get('loginProcess', [LoginController::class, 'action'])->name('loginProcess');
    Route::post('loginProcess', [LoginController::class, 'action'])->name('loginProcess');

    Route::get('forget', [LoginController::class, 'index'])->name('forget');
    Route::get('newPassword/{token}', [LoginController::class, 'index'])->name('newPassword');
    Route::post('newPassword', [LoginController::class, 'index'])->name('newPasswordSave');
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/', [HomeController::class, 'index']);
        Route::post('/', [HomeController::class, 'index']);

        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::post('home', [HomeController::class, 'index'])->name('home');
        Route::get('home', [HomeController::class, 'index'])->name('home.index');
        Route::post('home', [HomeController::class, 'index'])->name('home.index');
        Route::get('home', [HomeController::class, 'index'])->name('home');
    }
);

Route::group(
    ['namespace' => 'Master', 'middleware' => 'auth'],
    function () {
        Route::get('employee', [EmployeeController::class, 'employeeShow'])->name('employee')->middleware('userMatrix:M03.01');
        Route::get('employee/data/populate/{void}', [EmployeeController::class, 'populate'])->name('employee/data/populate');
    }
);
