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
use Maatwebsite\Excel\Facades\Excel;


use App\Exports\Report\Stock\ReportPosisiStock;


use App\Models\Employee;


class ReportStockController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "R01";

    public function reportStockShow()
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $kategori = kategoriGetRawData();
            $subKategori = subKategoriGetRawData();
            $merk = merkGetRawData();
            $lokasi = lokasiGetRawData();
            $account = accountGetRawData();
            $inventory = inventoryGetRawData();
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'kategori' => $kategori,
                'subKategori' => $subKategori,
                'merk' => $merk,
                'lokasi' => $lokasi,
                'account' => $account,
                'inventory' => $inventory,
            ];

            return View('report.stock.stock', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function reportPosisiStock(Request $request)
    {
        $module = $this->module;
        $menu_name = session('user')->menu_name;
        $user_token = session('user')->api_token;
        $url = config('constants.api_url') . '/reportPosisiStock';
        $json = array(
            'api_token' => $user_token,
            'edate' => Carbon::parse($request->edate)->format('Y-m-d'),
            'qty' => $request->qty,
            'isNilai' => ($request->isNilai == 'on') ? 'Y' : 'N',
            'lokasi' => $request->lokasi,
            'isGrouping' => ($request->isGrouping == 'on') ? 'Y' : 'N',
            'inventory' => $request->inventory,
            'merk' => $request->merk,
            'kategori' => $request->kategori,
            'subkategori' => $request->subKategori,
        );
        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $json]);
        $body = json_decode($response->getBody());

        $data = [
            'title' => $menu_name->$module->module_name,
            'edate' => Carbon::parse($request->edate)->format('d-m-Y'),
            'lokasi' => $request->lokasi,
            'posisiStock' => $body->posisiStock,
        ];

        if ($request->action == 'excel') {
            return Excel::download(new ReportPosisiStock($data), 'Report Posisi Stock.xlsx');
        } else {
            return view('report.stock.print.reportPosisiStock', $data);
        }
    }
}
