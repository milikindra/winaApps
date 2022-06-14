<?php

namespace App\Http\Controllers\Finance;

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
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// use App\Exports\Report\Stock\ReportPosisiStock;

class GeneralLedgerController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "F01";

    public function generalLedgerShow()
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
            return View('finance.generalLedger.generalLedger', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function populateAccountHistory(request $request, $gl_code, $sdate, $edate, $so_id, $id_employee, $dept_id)
    {
        // try {
        $user_token = session('user')->api_token;
        $offset = $request->start;
        $limit = $request->length;
        $keyword = $request->search['value'];
        $order = $request->order[0];
        $sort = [];
        foreach ($request->order as $key => $o) {
            $columnIdx = $o['column'];
            $sortDir = $o['dir'];
            $sort[] = [
                'column' => $request->columns[$columnIdx]['name'],
                'dir' => $sortDir
            ];
        }
        $columns = $request->columns;
        $draw = $request->draw;

        $post_data = [
            'search' => $keyword,
            'sort' => $sort,
            'current_page' => $offset / $limit + 1,
            'per_page' => $limit,
            'user' => session('user')->username,
            'gl_code' => $gl_code,
            'sdate' => $sdate,
            'edate' => $edate,
            'so_id' => $so_id,
            'id_employee' => $id_employee,
            'dept_id' => $dept_id,
        ];
        $url = Config::get('constants.api_url') . '/accountGl/getListAccountHistory';
        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());
        $table['draw'] = $draw;
        $table['recordsTotal'] = $body->total;
        $table['recordsFiltered'] = $body->recordsFiltered;
        $table['data'] = $body->accountGl;
        return json_encode($table);
        // } catch (\Exception $e) {
        //     Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

        //     return abort(500);
        // }
    }

    public function populateAccount(request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $offset = $request->start;
            $limit = $request->length;
            $keyword = $request->search['value'];
            $order = $request->order[0];
            $sort = [];
            foreach ($request->order as $key => $o) {
                $columnIdx = $o['column'];
                $sortDir = $o['dir'];
                $sort[] = [
                    'column' => $request->columns[$columnIdx]['name'],
                    'dir' => $sortDir
                ];
            }
            $columns = $request->columns;
            $draw = $request->draw;

            $post_data = [
                'search' => $keyword,
                'sort' => $sort,
                'current_page' => $offset / $limit + 1,
                'per_page' => $limit,
                'user' => session('user')->username,
            ];
            $url = Config::get('constants.api_url') . '/accountGl/getListAccount';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $table['draw'] = $draw;
            $table['recordsTotal'] = $body->total;
            $table['recordsFiltered'] = $body->recordsFiltered;
            $table['data'] = $body->accountGl;
            return json_encode($table);
        } catch (\Exception $e) {
            Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

            return abort(500);
        }
    }

    public function populateCoaTransaction(request $request,  $sdate, $edate, $trx_type, $trx_id)
    {
        // try {
        $user_token = session('user')->api_token;
        $offset = $request->start;
        $limit = $request->length;
        $keyword = $request->search['value'];
        $order = $request->order[0];
        $sort = [];
        foreach ($request->order as $key => $o) {
            $columnIdx = $o['column'];
            $sortDir = $o['dir'];
            $sort[] = [
                'column' => $request->columns[$columnIdx]['name'],
                'dir' => $sortDir
            ];
        }
        $columns = $request->columns;
        $draw = $request->draw;

        $post_data = [
            'search' => $keyword,
            'sort' => $sort,
            'current_page' => $offset / $limit + 1,
            'per_page' => $limit,
            'user' => session('user')->username,
            'sdate' => $sdate,
            'edate' => $edate,
            'trx_type' => $trx_type,
            'trx_id' => $trx_id,
        ];
        $url = Config::get('constants.api_url') . '/accountGl/getListCoaTransaction';
        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());
        $table['draw'] = $draw;
        $table['recordsTotal'] = $body->total;
        $table['recordsFiltered'] = $body->recordsFiltered;
        $table['data'] = $body->coaTrx;
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
        // dd($request);
        $export = $request->input('exportType');
        $dataType = $request->input('dataType');


        if ($dataType == 'appAccountHistory') {
            $url = config('constants.api_url') . '/accountGl/getListAccountHistory';
            $post_data = [
                'user' => session('user')->username,
                'gl_code' => $request->input('gl_code')[0],
                'sdate' => $request->input('sdate'),
                'edate' => $request->input('edate'),
                'so_id' => $request->input('so_id'),
                'id_employee' => $request->input('id_employee'),
                'dept_id' => $request->input('dept_id'),
            ];

            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $filter  = [
                'Account Number' => $request->input('gl_code')[0],
                'Start Date' =>  date_format(date_create($request->input('sdate')), 'd-m-Y'),
                'End Date' => date_format(date_create($request->input('edate')), 'd-m-Y'),
                'Sales Order' => strtoupper($request->input('so_id') == null ? 'all' : $request->input('so_id')),
                'Employee Id' => strtoupper($request->input('id_employee')),
                'Department' => strtoupper($request->input('dept_id')),
            ];
            $head = ['No Account', 'Account Name', 'Transaction Number', 'Date', 'SO', 'Employee', 'Description', 'Debet (IDR)', 'Credit (IDR)', 'Saldo (IDR)', 'Debet (Valas)', 'Credit (Valas)', 'Saldo (Valas)', 'Dept'];
            $data = [
                'title' => "GENERAL LEDGER - ACCOUNT HISTORY",
                'filter' => $filter,
                'head' => $head,
                'body' => $body->accountGl,

            ];

            if ($export == 'Print') {
                return view('finance.generalLedger.print.accountHistory', $data);
            } else {
                return view('finance.generalLedger.excel.accountHistory', $data);
            }
        } else if ($dataType == 'appCoaTransaction') {
            $url = config('constants.api_url') . '/accountGl/getListCoaTransaction';
            $trx_id = $request->input('trx_id');
            if ($trx_id == "") {
                $trx_id = "all";
            }
            $post_data = [
                'sdate' => $request->input('sdate'),
                'edate' => $request->input('edate'),
                'trx_type' => $request->input('trx_type'),
                'trx_id' => $trx_id,
                'dept_id' => $request->input('dept_id'),
            ];

            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $filter  = [
                'Start Date' =>  date_format(date_create($request->input('sdate')), 'd-m-Y'),
                'End Date' => date_format(date_create($request->input('edate')), 'd-m-Y'),
                'Transaction Number' => str_replace(":", "/",  $request->input('trx_id')),
                'Transaction Type' => strtoupper($request->input('trx_type')),
            ];

            if ($export == 'Print') {
                $url = config('constants.api_url') . '/accountGl/getListGlGroupTransaction';
                $client = new Client();
                $response = $client->request('POST', $url, ['json' => $post_data]);
                $body = json_decode($response->getBody());
                // dd($body);
                $data = [
                    'title' => "GENERAL LEDGER - TRANSACTION",
                    'filter' => $filter,
                    'body' => $body->coaTrx,
                ];
                return view('finance.generalLedger.print.generalLedgerTransaction', $data);
            } else {
                $url = config('constants.api_url') . '/accountGl/getListCoaTransaction';
                $client = new Client();
                $response = $client->request('POST', $url, ['json' => $post_data]);
                $body = json_decode($response->getBody());
                $head = ['Transaction', 'Account Number', 'Account Name', 'Transaction Number', 'Date', 'Description', 'Debet (IDR)', 'Credit (IDR)', 'Debet (Valas)', 'Credit (Valas)', 'Dept'];
                $data = [
                    'title' => "GENERAL LEDGER - TRANSACTION",
                    'filter' => $filter,
                    'head' => $head,
                    'body' => $body->coaTrx,
                ];
                return view('finance.generalLedger.excel.generalLedgerTransaction', $data);
            }
        }
    }
}
