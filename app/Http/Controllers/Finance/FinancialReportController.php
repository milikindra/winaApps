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
use RealRashid\SweetAlert\Facades\Alert;
// use Illuminate\Support\Carbon;
// use Maatwebsite\Excel\Facades\Excel;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Spipu\Html2Pdf\Html2Pdf;
use Barryvdh\DomPDF\Facade\Pdf;


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
        $user_token = session('user')->api_token;
        $post_data = [
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
        $table['data'] = $body->bbrl;
        return json_encode($table);
    }

    public function populateBalanceSheet(request $request, $sdate, $edate, $isTotal, $isParent, $isChild, $isZero, $isTotalParent, $isPercent, $isValas, $isShowCoa)
    {
        $user_token = session('user')->api_token;
        $draw = $request->draw;
        $post_data = [
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
        $table['data'] = $body->balance;
        return json_encode($table);
    }

    public function populatePnlProject(request $request, $edate, $so_id, $isAssumptionCost, $isOverhead)
    {
        $user_token = session('user')->api_token;
        $post_data = [
            'user' => session('user')->username,
            'edate' => $edate,
            'so_id' => $so_id,
            'isAssumptionCost' => $isAssumptionCost,
            'isOverhead' => $isOverhead,
        ];
        $url = Config::get('constants.api_url') . '/financialReport/getListPnlProject';
        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());
        $table['data'] = $body->balance;
        return json_encode($table);
    }

    public function populatePnlProjectList(request $request, $sdate, $edate, $isAssumptionCost, $isOverhead, $showProjectBy, $showProject)
    {
        $post_data = [
            'user' => session('user')->username,
            'sdate' => $sdate,
            'edate' => $edate,
            'isAssumptionCost' => $isAssumptionCost,
            'isOverhead' => $isOverhead,
            'showProjectBy' => $showProjectBy,
            'showProject' => $showProject,
        ];
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/financialReport/getListPnlProjectList';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $table['data'] = $body->balance;
            return json_encode($table);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            Log::debug($post_data);
            return abort(500);
        }
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
                'sdate' =>  date_format(date_create($request->input('sdate')), 'd-m-Y'),
                'edate' => date_format(date_create($request->input('edate')), 'd-m-Y'),
            ];

            $data = [
                'title' => "PT. VIKTORI PROFINDO AUTOMATION",
                'subtitle' => "FINANCIAL REPORT - INCOME STATEMENT",
                'filter' => $filter,
                'body' => $body->bbrl,
            ];
            if ($export == 'Print') {
                return view('finance.financialReport.print.incomeStatement', $data);
            } else if ($export == "Excel") {
                return view('finance.financialReport.excel.incomeStatement', $data);
            } else if ($export == "Pdf") {
                $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 8));
                $html2pdf->writeHTML(view('finance.financialReport.pdf.incomeStatement', $data));
                $html2pdf->output('Income Statement.pdf', 'D');
            } else {
                abort(500);
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
            if ($export == 'Print') {
                return view('finance.financialReport.print.balanceSheet', $data);
            } else if ($export == "Excel") {
                return view('finance.financialReport.excel.balanceSheet', $data);
            } else if ($export == "Pdf") {
                $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 8));
                $html2pdf->writeHTML(view('finance.financialReport.pdf.balanceSheet', $data));
                $html2pdf->output('Balance Sheet.pdf', 'D');
            } else {
                abort(500);
            }
        } else if ($dataType == 'appProjectPnl') {
            $url = config('constants.api_url') . '/financialReport/getListPnlProject';
            $post_data = [
                'user' => session('user')->username,
                'edate' => $request->input('edate'),
                'so_id' => $request->input('so_id'),
                'isAssumptionCost' => $request->input('isAssumptionCost'),
                'isOverhead' => $request->input('isOverhead'),
            ];

            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $filter  = "SO : " . $request->input('so_id') . " 
                        Per : " . date_format(date_create($request->input('edate')), 'd-m-Y');
            $data = [
                'title' => "PT. VIKTORI PROFINDO AUTOMATION",
                'subtitle' => "FINANCIAL REPORT - PROFIT AND LOSS PROJECT",
                'filter' => $filter,
                'body' => $body->balance,
            ];
            if ($export == 'Print') {
                return view('finance.financialReport.print.pnlProject', $data);
            } else if ($export == "Excel") {
                return view('finance.financialReport.excel.pnlProject', $data);
            } else if ($export == "Pdf") {
                $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 8));
                $html2pdf->writeHTML(view('finance.financialReport.pdf.pnlProject', $data));
                $html2pdf->output('Profit And Lost Project.pdf', 'D');
            } else {
                abort(500);
            }
        } else if ($dataType == 'appProjectPnlList') {
            $url = config('constants.api_url') . '/financialReport/getListPnlProjectList';
            $post_data = [
                'user' => session('user')->username,
                'sdate' => $request->input('sdate'),
                'edate' => $request->input('edate'),
                'so_id' => $request->input('so_id'),
                'isAssumptionCost' => $request->input('isAssumptionCost'),
                'isOverhead' => $request->input('isOverhead'),
                'showProjectBy' => $request->input('showProjectBy'),
                'showProject' => $request->input('showProject'),
            ];

            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $filter  = "Periode : " .  date_format(date_create($request->input('sdate')), 'd-m-Y') . " 
                        to : " . date_format(date_create($request->input('edate')), 'd-m-Y');
            $data = [
                'title' => "PT. VIKTORI PROFINDO AUTOMATION",
                'subtitle' => "FINANCIAL REPORT - PROFIT AND LOSS PROJECT (LIST)",
                'filter' => $filter,
                'body' => $body->balance,
            ];
            if ($export == 'Print') {
                return view('finance.financialReport.print.pnlProjectList', $data);
            } else if ($export == "Excel") {
                return view('finance.financialReport.excel.pnlProjectList', $data);
            } else if ($export == "Pdf") {
                // domPDF
                // $pdf = Pdf::loadView('finance.financialReport.pdf.pnlProjectList', $data);
                // $pdf->setPaper('A4');
                // return $pdf->download('Profit And Lost Project (List).pdf');

                // wkhtmltopdf -> snappyPdf
                // $pdf = SnappyPdf::loadView('finance.financialReport.pdf.pnlProjectList', $data);
                // $pdf->setPaper('A4');
                // $pdf->setOrientation('portrait');
                // $pdf->setOption('margin-right', '3');
                // $pdf->setOption('margin-left', '3');
                // $pdf->setOption('margin-top', '3');
                // $pdf->setOption('margin-bottom', '3');
                // return $pdf->download('Profit And Lost Project (List).pdf');

                // TCPDF -> Spipu
                $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 8));
                $html2pdf->writeHTML(view('finance.financialReport.pdf.pnlProjectList', $data));
                $html2pdf->output('Profit And Lost Project (List).pdf', 'D');
            } else {
                abort(500);
            }
        }
    }

    public function getPnlProject($so_id)
    {
        $url = config('constants.api_url') . '/getPnlProject';
        $post_data = [
            'user' => session('user')->username,
            'so_id' => $so_id,
        ];

        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());

        $url = config('constants.api_url') . '/soGetById';
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $so = json_decode($response->getBody());

        $data = [
            'body' => $body->balance,
            'so' => $so->so,
        ];
        return json_encode($data);
    }

    public function pnlProjectSave(Request $request)
    {
        $url = config('constants.api_url') . '/pnlProjectSave';
        $post_data = [
            'user' => session('user')->username,
            'data' => $request['datas'],
            'so_id' => $request['so_id'],
            'note_ph' => $request['notePh'],
        ];

        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());
        $data = [
            'result' => $body->result,
            'message' => $body->message
        ];
        // if ($data['result'] == true) {
        //     Alert::toast($body->message, 'success');
        // } else {
        //     Alert::toast($body->message, 'danger');
        // }

        return json_encode($data);
    }
}
