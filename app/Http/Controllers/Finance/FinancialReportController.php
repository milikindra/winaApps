<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
// use RealRashid\SweetAlert\Facades\Alert;
// use Illuminate\Support\Carbon;
// use Maatwebsite\Excel\Facades\Excel;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class FinancialReportController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "F02";

    public function financialReportShow()
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $dept = deptGetRawData();
            $employee = employeeGetRawData();
            $trxType = trxTypeFromGlCard();
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'dept' => $dept,
                'employee' => $employee,
                'trxType' => $trxType,
            ];
            return View('finance.financialReport.financialReport', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function populateIncomeStatement(request $request, $sdate, $edate, $isTotal, $isParent, $isChild, $isZero, $isTotalParent, $isPercent, $isValas, $isShowCoa)
    {
        // try {
        $user_token = session('user')->api_token;
        $offset = $request->start;
        $limit = $request->length;
        $keyword = $request->search['value'];
        // $order = $request->order[0];
        // $sort = [];
        // foreach ($request->order as $key => $o) {
        //     $columnIdx = $o['column'];
        //     $sortDir = $o['dir'];
        //     $sort[] = [
        //         'column' => $request->columns[$columnIdx]['name'],
        //         'dir' => $sortDir
        //     ];
        // }
        $columns = $request->columns;
        $draw = $request->draw;

        $post_data = [
            'search' => $keyword,
            // 'sort' => $sort,
            'current_page' => $offset / $limit + 1,
            'per_page' => $limit,
            'user' => session('user')->username,
            'sdate' => $sdate,
            'edate' => $edate,
            'isTotal' => $isTotal,
            'isParent' => $isParent,
            'isChild' => $isChild,
            'isZero' => $isZero,
            'isTotalParent' => $isTotalParent,
            'isPercent' => $isPercent,
            'isValas' => $isValas,
            'isShowCoa' => $isShowCoa,
        ];
        $url = Config::get('constants.api_url') . '/financialReport/getListIncomeStatement';
        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());
        $table['draw'] = $draw;
        $table['recordsTotal'] = $body->total;
        $table['recordsFiltered'] = $body->recordsFiltered;
        $table['data'] = $body->bbrl;
        // log::debug($table);
        return json_encode($table);
        // } catch (\Exception $e) {
        //     Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

        //     return abort(500);
        // }
    }

    public function populateBalanceSheet(request $request, $sdate, $edate, $isTotal, $isParent, $isChild, $isZero, $isTotalParent, $isPercent, $isValas, $isShowCoa)
    {
        // try {
        $user_token = session('user')->api_token;
        $offset = $request->start;
        $limit = $request->length;
        $keyword = $request->search['value'];
        // $order = $request->order[0];
        // $sort = [];
        // foreach ($request->order as $key => $o) {
        //     $columnIdx = $o['column'];
        //     $sortDir = $o['dir'];
        //     $sort[] = [
        //         'column' => $request->columns[$columnIdx]['name'],
        //         'dir' => $sortDir
        //     ];
        // }
        $columns = $request->columns;
        $draw = $request->draw;

        $post_data = [
            'search' => $keyword,
            // 'sort' => $sort,
            'current_page' => $offset / $limit + 1,
            'per_page' => $limit,
            'user' => session('user')->username,
            'sdate' => $sdate,
            'edate' => $edate,
            'isTotal' => $isTotal,
            'isParent' => $isParent,
            'isChild' => $isChild,
            'isZero' => $isZero,
            'isTotalParent' => $isTotalParent,
            'isPercent' => $isPercent,
            'isValas' => $isValas,
            'isShowCoa' => $isShowCoa,
        ];
        $url = Config::get('constants.api_url') . '/financialReport/getListBalanceSheet';
        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());
        $table['draw'] = $draw;
        $table['recordsTotal'] = $body->total;
        $table['recordsFiltered'] = $body->recordsFiltered;
        $table['data'] = $body->balance;
        return json_encode($table);
        // } catch (\Exception $e) {
        //     Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

        //     return abort(500);
        // }
    }


    public function export(request $request)
    {
        $module = $this->module;
        $menu_name = session('user')->menu_name;
        $user_token = session('user')->api_token;
        $export = $request->input('exportType');
        $dataType = $request->input('dataType');


        if ($dataType == 'appIncomeStatement') {
            $url = config('constants.api_url') . '/financialReport/getListIncomeStatement';
            $post_data = [
                'user' => session('user')->username,
                'sdate' => $request->input('sdate'),
                'edate' => $request->input('edate'),
                'isTotal' => $request->input('isTotal'),
                'isParent' => $request->input('isParent'),
                'isChild' => $request->input('isChild'),
                'isZero' => $request->input('isZero'),
                'isTotalParent' => $request->input('isTotalParent'),
                'isPercent' => $request->input('isPercent'),
                'isValas' => $request->input('isValas'),
                'isShowCoa' => $request->input('isShowCoa'),
            ];

            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $filter  = [
                'Start Date' =>  date_format(date_create($request->input('sdate')), 'd-m-Y'),
                'End Date' => date_format(date_create($request->input('edate')), 'd-m-Y'),
            ];

            $data = [
                'title' => "PT. VIKTORI PROFINDO AUTOMATION",
                'subtitle' => "FINANCIAL REPORT - INCOME STATEMENT",
                'filter' => $filter,
                'body' => $body->bbrl,
            ];
            if ($export == 'Print') {
                return view('finance.financialReport.print.incomeStatement', $data);
            } else {
                return view('finance.financialReport.excel.incomeStatement', $data);
            }
        } else if ($dataType == 'appBalanceSheet') {
            $url = config('constants.api_url') . '/financialReport/getListBalanceSheet';
            $post_data = [
                'user' => session('user')->username,
                'sdate' => $request->input('sdate'),
                'edate' => $request->input('edate'),
                'isTotal' => $request->input('isTotal'),
                'isParent' => $request->input('isParent'),
                'isChild' => $request->input('isChild'),
                'isZero' => $request->input('isZero'),
                'isTotalParent' => $request->input('isTotalParent'),
                'isPercent' => $request->input('isPercent'),
                'isValas' => $request->input('isValas'),
                'isShowCoa' => $request->input('isShowCoa'),
            ];

            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $filter  = [
                'edate' => date_format(date_create($request->input('edate')), 'd-m-Y'),
            ];

            $data = [
                'title' => "PT. VIKTORI PROFINDO AUTOMATION",
                'subtitle' => "FINANCIAL REPORT - BALANCE SHEET",
                'filter' => $filter,
                'body' => $body->balance,
            ];
            // dd($body->balance);
            if ($export == 'Print') {
                return view('finance.financialReport.print.balanceSheet', $data);
            } else {
                return view('finance.financialReport.excel.balanceSheet', $data);
            }
        }
    }
}