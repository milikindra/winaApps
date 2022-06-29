<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Spipu\Html2Pdf\Html2Pdf;


class StatementOfAccountController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "F03";

    public function statementOfAccountShow()
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
            return View('finance.statementOfAccount.statementOfAccount', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function populateCustomerSOA(request $request, $edate, $customer, $so, $sales, $overdue, $isTotal)
    {
        $user_token = session('user')->api_token;
        $post_data = [
            'user' => session('user')->username,
            'edate' => $edate,
            'customer' => ($customer == 'all') ? '' : $customer,
            'so' => ($so == 'all') ? '' : $so,
            'sales' => ($sales == 'all') ? '' : $sales,
            'overdue' => ($overdue == 'all') ? '' : $overdue,
            'isTotal' => ($isTotal == 'Y') ? 'Y' : '',
        ];
        $url = Config::get('constants.api_url') . '/statementOfAccount/getListCustomerSOA';
        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());
        $table['data'] = $body->soa;
        return json_encode($table);
    }

    public function populateSupplierSOA(request $request, $edate, $supplier, $inventory, $tag, $overdue, $isTotal)
    {
        $user_token = session('user')->api_token;
        $post_data = [
            'user' => session('user')->username,
            'edate' => $edate,
            'supplier' => ($supplier == 'all') ? '' : $supplier,
            'inventory' => ($inventory == 'all') ? '' : $inventory,
            'tag' => ($tag == 'all') ? '' : $tag,
            'overdue' => ($overdue == 'all') ? '' : $overdue,
            'isTotal' => ($isTotal == 'Y') ? 'Y' : '',
        ];
        $url = Config::get('constants.api_url') . '/statementOfAccount/getListSupplierSOA';
        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());
        $table['data'] = $body->soa;
        return json_encode($table);
    }


    public function export(request $request)
    {
        $module = $this->module;
        $menu_name = session('user')->menu_name;
        $user_token = session('user')->api_token;
        $export = $request->input('exportType');
        $dataType = $request->input('dataType');

        if ($dataType == 'appCustomerSOA') {
            $url = config('constants.api_url') . '/statementOfAccount/getListCustomerSOA';
            $post_data = [
                'user' => session('user')->username,
                'edate' => $request->input('edate'),
                'customer' => $request->input('customer'),
                'so' => $request->input('so'),
                'sales' => $request->input('sales'),
                'overdue' => $request->input('overdue'),
                'isTotal' => $request->input('isTotal'),
            ];

            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $filter  = "Per : " . date_format(date_create($request->input('edate')), 'd-m-Y');

            $data = [
                'title' => "PT. VIKTORI PROFINDO AUTOMATION",
                'subtitle' => "CUSTOMER STATEMENT OF ACCOUNT",
                'filter' => $filter,
                'body' => $body->soa,
            ];
            if ($export == 'Print') {
                return view('finance.statementOfAccount.print.customerSOA', $data);
            } else if ($export == "Excel") {
                return view('finance.statementOfAccount.excel.customerSOA', $data);
            } else if ($export == "Pdf") {
                $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 8));
                $html2pdf->writeHTML(view('finance.statementOfAccount.pdf.customerSOA', $data));
                $html2pdf->output('Statement Of Account.pdf', 'D');
            } else {
                abort(500);
            }
        } else if ($dataType == 'appSupplierSOA') {
            $url = config('constants.api_url') . '/statementOfAccount/getListSupplierSOA';

            $post_data = [
                'user' => session('user')->username,
                'edate' => $request->input('edate'),
                'supplier' => $request->input('supplier'),
                'inventory' => $request->input('inventory'),
                'tag' => $request->input('tag'),
                'overdue' => $request->input('overdue'),
                'isTotal' => $request->input('isTotal'),
            ];

            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $filter  = "Per : " . date_format(date_create($request->input('edate')), 'd-m-Y');

            $data = [
                'title' => "PT. VIKTORI PROFINDO AUTOMATION",
                'subtitle' => "SUPPLIER STATEMENT OF ACCOUNT",
                'filter' => $filter,
                'body' => $body->soa,
            ];
            if ($export == 'Print') {
                return view('finance.statementOfAccount.print.supplierSOA', $data);
            } else if ($export == "Excel") {
                return view('finance.statementOfAccount.excel.supplierSOA', $data);
            } else if ($export == "Pdf") {
                $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 8));
                $html2pdf->writeHTML(view('finance.statementOfAccount.pdf.supplierSOA', $data));
                $html2pdf->output('Statement Of Account.pdf', 'D');
            } else {
                abort(500);
            }
        }
    }
}
