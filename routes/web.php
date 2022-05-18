<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Master\EmployeeController;
use App\Http\Controllers\Master\CityController;
use App\Http\Controllers\Master\InventoryController;
use App\Http\Controllers\Transaction\SalesOrderController;
use App\Http\Controllers\Report\ReportStockController;
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
    ['middleware' => 'authApi'],
    function () {
        // Route::get('/', [HomeController::class, 'index']);
        // Route::post('/', [HomeController::class, 'index']);

        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::post('home', [HomeController::class, 'index'])->name('home');
        Route::get('home', [HomeController::class, 'index'])->name('home.index');
        Route::post('home', [HomeController::class, 'index'])->name('home.index');
        Route::get('home', [HomeController::class, 'index'])->name('home');
    }
);

Route::group(
    ['namespace' => 'Master', 'middleware' => 'authApi'],
    function () {
        // employee
        Route::get('employee', [EmployeeController::class, 'employeeShow'])->name('employee')->middleware('userMatrix:M03.01');
        Route::get('employee/data/populate/{void}', [EmployeeController::class, 'populate'])->name('employee/data/populate');
        Route::get('employeeAdd', [EmployeeController::class, 'employeeAdd'])->name('employeeAdd')->middleware('userMatrix:M03.02');
        Route::post('employeeAddSave', [EmployeeController::class, 'employeeAddSave'])->name('employeeAddSave')->middleware('userMatrix:M03.02');
        Route::get('employeeDetail/{id}', [EmployeeController::class, 'employeeDetail'])->name('employeeDetail')->middleware('userMatrix:M03.01');
        Route::get('employeeEdit/{id}', [EmployeeController::class, 'employeeEdit'])->name('employeeEdit')->middleware('userMatrix:M03.03');
        // Route::post('employeeEditSave', [EmployeeController::class, 'employeeEditSave'])->name('employeeEditSave')->middleware('userMatrix:M03.03');

        // province

        // city
        Route::get('getCity', [CityController::class, 'getCity'])->name('getCity');

        // district

        // village

        // merk

        // inventory
        Route::get('inventory', [InventoryController::class, 'inventoryShow'])->name('inventory')->middleware('userMatrix:M02.01');
        Route::get('inventory/data/populate/{void}/{kategori}/{subkategori}', [InventoryController::class, 'populate'])->name('inventory/data/populate');
        Route::post('inventoryAddSave', [InventoryController::class, 'inventoryAddSave'])->name('inventoryAddSave')->middleware('userMatrix:M02.02');
        Route::get('inventory/data/edit/{inv}', [InventoryController::class, 'inventoryEdit'])->name('inventory/data/edit');
        Route::post('inventoryUpdate', [InventoryController::class, 'inventoryUpdate'])->name('inventoryUpdate')->middleware('userMatrix:M02.03');
        Route::get('inventory/data/delete/{inv}', [InventoryController::class, 'inventoryDelete'])->name('inventory/data/delete')->middleware('userMatrix:M02.04');
        Route::post('kartuStok', [InventoryController::class, 'kartuStok'])->name('kartuStok')->middleware('userMatrix:M02.01');;
        Route::get('kartuStok/data/populate/{kode}/{sdate}/{edate}/{lokasi}/{item_transfer}', [InventoryController::class, 'kartuStokPopulate'])->name('kartuStok/data/populate');
    }
);


Route::group(
    ['namespace' => 'Transaction', 'middleware' => 'authApi'],
    function () {
        Route::get('salesOrder', [SalesOrderController::class, 'salesOrderShow'])->name('salesOrder')->middleware('userMatrix:T01.01');
        Route::get('salesOrder/data/populate/{void}/{kategori}/{fdate}/{sdate}/{edate}', [SalesOrderController::class, 'populate'])->name('salesOrder/data/populate');
    }
);

Route::group(
    ['namespace' => 'Report', 'middleware' => 'authApi'],
    function () {
        Route::get('reportStock', [ReportStockController::class, 'reportStockShow'])->name('reportStock')->middleware('userMatrix:R01.01');
        Route::post('reportPosisiStock', [ReportStockController::class, 'reportPosisiStock'])->name('reportPosisiStock')->middleware('userMatrix:RX01.01');
    }
);
