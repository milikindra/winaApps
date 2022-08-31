<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Master\EmployeeController;
use App\Http\Controllers\Master\CityController;
use App\Http\Controllers\Master\InventoryController;
use App\Http\Controllers\Master\CustomerController;
use App\Http\Controllers\Master\SalesController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Master\VintrasController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\SubCategoryController;
use App\Http\Controllers\Master\MerkController;
use App\Http\Controllers\Master\AccountCoaController;
use App\Http\Controllers\Master\VatController;
use App\Http\Controllers\Master\EfakturController;
use App\Http\Controllers\Transaction\SalesOrderController;
use App\Http\Controllers\Transaction\SalesInvoiceController;
use App\Http\Controllers\Finance\GeneralLedgerController;
use App\Http\Controllers\Finance\FinancialReportController;
use App\Http\Controllers\Finance\StatementOfAccountController;
use App\Http\Controllers\Report\ReportStockController;
use App\Http\Controllers\Report\ReportHelperController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\EfakturGeneratorController;
// use Illuminate\Support\Facades\URL;
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
    ['namespace' => 'Transaction', 'middleware' => 'authApi'],
    function () {
        // salesOrder
        Route::get('salesOrder', [SalesOrderController::class, 'salesOrderShow'])->name('salesOrder')->middleware('userMatrix:T01.01');
        Route::get('salesOrder/data/populate/{void}/{kategori}/{fdate}/{sdate}/{edate}', [SalesOrderController::class, 'populate'])->name('salesOrder/data/populate');
        Route::get('salesOrder/data/populateHead/{field}/{value}', [SalesOrderController::class, 'populateHead'])->name('salesOrder/data/populateHead');
        Route::get('salesOrderAdd', [SalesOrderController::class, 'salesOrderAdd'])->name('salesOrderAdd')->middleware('userMatrix:T01.02');
        Route::post('salesOrderAddSave', [SalesOrderController::class, 'salesOrderAddSave'])->name('salesOrderAddSave')->middleware('userMatrix:T01.02');
        Route::get('salesOrderDetail/{void}/{id}', [SalesOrderController::class, 'salesOrderDetail'])->name('salesOrderDetail')->middleware('userMatrix:T01.01');
        Route::post('salesOrderUpdate', [SalesOrderController::class, 'salesOrderUpdate'])->name('salesOrderUpdate')->middleware('userMatrix:T01.03');
        Route::get('salesOrderPrint/{id}', [SalesOrderController::class, 'salesOrderPrint'])->name('salesOrderPrint');
        Route::get('salesOrderStatus/{id}', [SalesOrderController::class, 'salesOrderStatus'])->name('salesOrderStatus');
        Route::get('salesOrder/void/{id}', [SalesOrderController::class, 'salesOrderDelete'])->name('salesOrder/void')->middleware('userMatrix:T01.04');
        Route::post('salesOrder/state', [SalesOrderController::class, 'salesOrderUpdateState'])->name('salesOrder/state')->middleware('userMatrix:T01.03');
        Route::post('salesOrder/cekSo', [SalesOrderController::class, 'salesOrderCek'])->name('salesOrder/cekSo');

        // salesInvoice
        Route::get('siGetEfaktur/{id}', [SalesInvoiceController::class, 'siGetEfaktur'])->name('siGetEfaktur');
        Route::get('salesInvoice', [SalesInvoiceController::class, 'salesInvoiceShow'])->name('salesInvoice')->middleware('userMatrix:T02.01');
        Route::get('salesInvoice/data/populate/{void}/{kategori}/{fdate}/{sdate}/{edate}', [SalesInvoiceController::class, 'populate'])->name('salesInvoice/data/populate');
        Route::get('salesInvoiceAdd', [SalesInvoiceController::class, 'salesInvoiceAdd'])->name('salesInvoiceAdd')->middleware('userMatrix:T02.02');
        Route::get('salesInvoice/data/do/{so_id}', [SalesInvoiceController::class, 'dataDo'])->name('salesInvoice/data/do');
        Route::get('salesInvoice/get/do/{so_id}/{do_id}', [SalesInvoiceController::class, 'getDo'])->name('salesInvoice/get/do');
        Route::get('salesInvoice/data/sodp/{so_id}', [SalesInvoiceController::class, 'dataSoDp'])->name('salesInvoice/data/sodp');
        Route::get('salesInvoice/get/sodp/{so_id}/{do_id}', [SalesInvoiceController::class, 'getSoDp'])->name('salesInvoice/get/sodp');
        Route::post('salesInvoiceAddSave', [SalesInvoiceController::class, 'salesInvoiceAddSave'])->name('salesInvoiceAddSave')->middleware('userMatrix:T02.02');
        Route::get('salesInvoiceDetail/{void}/{id}', [SalesInvoiceController::class, 'salesInvoiceDetail'])->name('salesInvoiceDetail')->middleware('userMatrix:T02.01');
        Route::get('salesInvoicePrint/{f}/{id}', [SalesInvoiceController::class, 'salesInvoicePrint'])->name('salesInvoicePrint');
        Route::post('salesInvoiceUpdate', [SalesInvoiceController::class, 'salesInvoiceUpdate'])->name('salesInvoiceUpdate')->middleware('userMatrix:T02.03');
        Route::get('salesInvoice/void/{id}', [SalesInvoiceController::class, 'salesInvoiceDelete'])->name('salesInvoice/void')->middleware('userMatrix:T02.04');
        Route::get('salesInvoiceStatus/{id}', [SalesInvoiceController::class, 'salesinvoiceStatus'])->name('salesinvoiceStatus');
    }
);

Route::group(
    ['namespace' => 'Finance', 'middleware' => 'authApi'],
    function () {
        // generalLedger
        Route::get('generalLedger', [GeneralLedgerController::class, 'generalLedgerShow'])->name('generalLedger')->middleware('userMatrix:F01.01');
        Route::get('generalLedger/data/populateAccountHistory/{gl_code}/{sdate}/{edate}/{so_id}/{id_employee}/{dept_id}', [GeneralLedgerController::class, 'populateAccountHistory'])->name('generalLedger/data/populateAccountHistory');
        Route::get('generalLedger/data/populateAccount', [GeneralLedgerController::class, 'populateAccount'])->name('generalLedger/data/populateAccount');
        Route::get('generalLedger/data/populateCoaTransaction/{sdate}/{edate}/{trx_type}/{trx_id}', [GeneralLedgerController::class, 'populateCoaTransaction'])->name('generalLedger/data/populateCoaTransaction');
        Route::get('generalLedger/data/populateCashBankDetail/{gl_code}/{sdate}/{edate}', [GeneralLedgerController::class, 'populateCashBankDetail'])->name('generalLedger/data/populateCoaTransaction');
        Route::post('generalLedger/export', [GeneralLedgerController::class, 'export'])->name('generalLedger/export')->middleware('userMatrix:F01.01');

        // financialReport
        Route::get('financialReport', [FinancialReportController::class, 'financialReportShow'])->name('financialReport')->middleware('userMatrix:F02.01');
        Route::post('financialReport/export', [FinancialReportController::class, 'export'])->name('financialReport/export')->middleware('userMatrix:F02.01');
        Route::get('financialReport/data/populateIncomeStatement/{sdate}/{edate}/{isTotal}/{isParent}/{isChild}/{isZero}/{isTotalParent}/{isPercent}/{isValas}/{isShowCoa}', [FinancialReportController::class, 'populateIncomeStatement'])->name('financialReport/data/populateIncomeStatement');
        Route::get('financialReport/data/populateBalanceSheet/{sdate}/{edate}/{isTotal}/{isParent}/{isChild}/{isZero}/{isTotalParent}/{isPercent}/{isValas}/{isShowCoa}', [FinancialReportController::class, 'populateBalanceSheet'])->name('financialReport/data/populateBalanceSheet');
        Route::get('financialReport/data/populatePnlProject/{edate}/{so_id}/{isAssumptionCost}/{isOverhead}', [FinancialReportController::class, 'populatePnlProject'])->name('financialReport/data/populatePnlProject');
        Route::get('financialReport/data/populatePnlProjectList/{sdate}/{edate}/{isAssumptionCost}/{isOverhead}/{showProjectBy}/{showProject}/{isCache}', [FinancialReportController::class, 'populatePnlProjectList'])->name('financialReport/data/populatePnlProjectList');
        Route::get('getPnlProject/{id}', [FinancialReportController::class, 'getPnlProject'])->name('getPnlProject');
        Route::post('pnlProjectSave', [FinancialReportController::class, 'pnlProjectSave'])->name('pnlProjectSave');

        // statementOfAccount
        Route::get('statementOfAccount', [StatementOfAccountController::class, 'statementOfAccountShow'])->name('statementOfAccount')->middleware('userMatrix:F03.01');
        Route::get('statementOfAccount/data/populateCustomerSOA/{edate}/{customer}/{so}/{sales}/{overdue}/{isTotal}', [statementOfAccountController::class, 'populateCustomerSOA'])->name('statementOfAccount/data/populateCustomerSOA');
        Route::get('statementOfAccount/data/populateSupplierSOA/{edate}/{supplier}/{inventory}/{tag}/{overdue}/{isTotal}', [statementOfAccountController::class, 'populateSupplierSOA'])->name('statementOfAccount/data/populateSupplierSOA');
        Route::post('statementOfAccount/internalNotes', [StatementOfAccountController::class, 'internalNotes'])->name('statementOfAccount/internalNotes')->middleware('userMatrix:F03.02');
        Route::post('statementOfAccount/export', [StatementOfAccountController::class, 'export'])->name('statementOfAccount/export')->middleware('userMatrix:F03.03');
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

        // coa
        Route::get('coaShow', [AccountCoaController::class, 'coaShow'])->name('coaShow')->middleware('userMatrix:M10.01');
        Route::get('coaGetById/{id}', [AccountCoaController::class, 'coaGetById'])->name('coaGetById');

        // merk
        Route::get('merkInventory', [MerkController::class, 'merkInventoryShow'])->name('merkInventory')->middleware('userMatrix:M01.01');
        Route::get('merkGetById/{id}', [MerkController::class, 'merkGetById'])->name('merkGetById');

        // kategori
        Route::get('categoryInventory', [CategoryController::class, 'categoryInventoryShow'])->name('categoryInventory')->middleware('userMatrix:M08.01');
        Route::get('categoryGetById/{id}', [CategoryController::class, 'categoryGetById'])->name('categoryGetById');

        // subkategori
        Route::get('subCategoryInventory', [SubCategoryController::class, 'subCategoryInventoryShow'])->name('subCategoryInventory')->middleware('userMatrix:M09.01');
        Route::get('subCategoryGetById/{id}', [SubCategoryController::class, 'subCategoryGetById'])->name('subCategoryGetById');

        // inventory
        Route::get('inventory', [InventoryController::class, 'inventoryShow'])->name('inventory')->middleware('userMatrix:M02.01');
        Route::get('inventory/data/populate/{void}/{kategori}/{subkategori}/{um}', [InventoryController::class, 'populate'])->name('inventory/data/populate');
        Route::post('inventoryAddSave', [InventoryController::class, 'inventoryAddSave'])->name('inventoryAddSave')->middleware('userMatrix:M02.02');
        Route::get('inventory/data/edit/{inv}', [InventoryController::class, 'inventoryEdit'])->name('inventory/data/edit');
        Route::post('inventoryUpdate', [InventoryController::class, 'inventoryUpdate'])->name('inventoryUpdate')->middleware('userMatrix:M02.03');
        Route::get('inventory/data/delete/{inv}', [InventoryController::class, 'inventoryDelete'])->name('inventory/data/delete')->middleware('userMatrix:M02.04');
        Route::post('kartuStok', [InventoryController::class, 'kartuStok'])->name('kartuStok')->middleware('userMatrix:M02.01');;
        Route::get('kartuStok/data/populate/{kode}/{sdate}/{edate}/{lokasi}/{item_transfer}', [InventoryController::class, 'kartuStokPopulate'])->name('kartuStok/data/populate');
        Route::get('inventoryChildGetByHead/{inv}', [InventoryController::class, 'inventoryChildGetByHead'])->name('inventoryChildGetByHead');

        // customer
        Route::get('customer', [CustomerController::class, 'customerShow'])->name('customer')->middleware('userMatrix:M04.01');
        Route::get('customerGetById/{id}', [CustomerController::class, 'customerGetById'])->name('customerGetById');
        Route::get('customerGetForSi/{id}', [CustomerController::class, 'customerGetForSi'])->name('customerGetForSi');
        Route::get('customer/data/populate/{void}', [CustomerController::class, 'populate'])->name('customer/data/populate');
        Route::post('customerAddSave', [CustomerController::class, 'customerAddSave'])->name('customerAddSave')->middleware('userMatrix:M04.02');
        Route::get('customer/data/edit/{kode}', [CustomerController::class, 'customerEdit'])->name('customer/data/edit');
        Route::post('customerUpdate', [CustomerController::class, 'customerUpdate'])->name('customerUpdate')->middleware('userMatrix:M04.03');
        Route::post('customer/addBranch', [CustomerController::class, 'addBRanch'])->name('customer/addBranch')->middleware('userMatrix:M04.01');
        Route::get('customer/void/{id}', [CustomerController::class, 'customerDelete'])->name('customer/void')->middleware('userMatrix:M02.04');


        // sales
        Route::get('sales/data/populate/{void}', [SalesController::class, 'populate'])->name('sales/data/populate');

        // supplier
        Route::get('supplier/data/populate/{void}', [SupplierController::class, 'populate'])->name('supplier/data/populate');

        // vintras
        Route::get('vintras/data/populate/{period}', [VintrasController::class, 'populate'])->name('vintras/data/populate');

        // vat
        Route::get('vat', [VatController::class, 'vatShow'])->name('vat')->middleware('userMatrix:M11.01');
        Route::get('vat/data/populate/{sdate}', [VatController::class, 'populate'])->name('vat/data/populate');
        Route::get('vat/data/byDate/{sdate}', [VatController::class, 'byDate'])->name('vat/data/byDate');

        //efaktur
        Route::get('efaktur/get/byDate/{dates}', [EfakturController::class, 'byDate'])->name('efaktur/get/byDate');
    }
);

Route::group(
    ['namespace' => 'Report', 'middleware' => 'authApi'],
    function () {
        // stock
        Route::get('reportStock', [ReportStockController::class, 'reportStockShow'])->name('reportStock')->middleware('userMatrix:R01.01');
        Route::post('reportPosisiStock', [ReportStockController::class, 'reportPosisiStock'])->name('reportPosisiStock')->middleware('userMatrix:RX01.01');

        // helper
        Route::get('reportHelper', [ReportHelperController::class, 'reportHelperShow'])->name('reportHelper')->middleware('userMatrix:R02.01');
        Route::post('reportTransmitalReceipt', [ReportHelperController::class, 'reportTransmitalReceipt'])->name('reportTransmitalReceipt')->middleware('userMatrix:RY01.01');
    }
);

// efakturGenerator
Route::get('efakturGenerator/{id}/{ba}/{bc}', [EfakturGeneratorController::class, 'generateCsv'])->name('efakturGenerator');

Route::get('getFile/{path}', [FileController::class, 'getFile'])->name('getFile');
