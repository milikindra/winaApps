<?php

namespace App\Http\Controllers\Report;

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
// use Maatwebsite\Excel\Facades\Excel;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// use App\Exports\Report\Stock\ReportPosisiStock;

class ReportHelperCOntroller extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "R02";

    public function reportHelperShow()
    {
        // try {
        $module = $this->module;
        $menu_name = session('user')->menu_name;
        $customer = customerGetRawData('NM_CUST', 'ASC');
        $data = [
            'title' => $menu_name->$module->module_name,
            'parent_page' => $menu_name->$module->parent_name,
            'page' => $menu_name->$module->module_name,
            'customer' => $customer,
        ];

        return View('report.helper.helper', $data);
        // } catch (\Exception $e) {
        //     Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
        //     return abort(500);
        // }
    }
}
