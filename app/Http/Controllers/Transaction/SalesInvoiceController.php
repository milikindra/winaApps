<?php

namespace App\Http\Controllers\Transaction;

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

class SalesInvoiceController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "T02";
    public function siGetEfaktur(request $request, $id)
    {
        $data = siGetEfaktur($id);
        return json_encode($data);
    }

    public function salesInvoiceShow()
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name;

            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,

            ];
            return View('transaction.salesInvoice.salesInvoice', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function populate(Request $request, $void, $kategori, $fdate, $sdate, $edate)
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
                'void' => $void,
                'kategori' => $kategori,
                'fdate' => $fdate,
                'sdate' => $sdate,
                'edate' => $edate
            ];
            $url = Config::get('constants.api_url') . '/salesInvoice/getList';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $table['draw'] = $draw;
            $table['recordsTotal'] = $body->total;
            $table['recordsFiltered'] = $body->recordsFiltered;
            $table['data'] = $body->si;

            return json_encode($table);
        } catch (\Exception $e) {
            Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

            return abort(500);
        }
    }

    public function salesInvoiceAdd()
    {
        try {
            $user_token = session('user')->api_token;
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $sales = salesGetRawData('ID_SALES', 'ASC');
            $lokasi = lokasiGetRawData();
            $vat = vatGetData(date('Y-m-d'), 'all');
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'sales' => $sales,
                'lokasi' => $lokasi,
                'vat' => $vat,
            ];
            return View('transaction.salesInvoice.salesInvoiceAdd', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function salesInvoiceAddSave(Request $request)
    {
        dd($request);
    }

    public function dataDo(Request $request, $so_id)
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
                'so_id' => $so_id,
            ];
            $url = Config::get('constants.api_url') . '/salesInvoice/dataDo';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $table['draw'] = $draw;
            $table['recordsTotal'] = $body->total;
            $table['recordsFiltered'] = $body->recordsFiltered;
            $table['data'] = $body->si;

            return json_encode($table);
        } catch (\Exception $e) {
            Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

            return abort(500);
        }
    }

    public function getDo(Request $request, $do_id)
    {
        try {
            $user_token = session('user')->api_token;
            $post_data = [
                'user' => session('user')->username,
                'do_id' => base64_decode($do_id),
            ];

            $url = Config::get('constants.api_url') . '/salesInvoice/getDo';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            return json_encode($body);
        } catch (\Exception $e) {
            Log::debug($request->path());
            Log::debug($e);
            return abort(500);
        }
    }

    public function dataSoDp(Request $request, $so_id)
    {
        try {
            $user_token = session('user')->api_token;
            $post_data = [
                'user' => session('user')->username,
                'so_id' => $so_id,
            ];

            $url = Config::get('constants.api_url') . '/salesInvoice/dataSoDp';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            return json_encode($body);
        } catch (\Exception $e) {
            Log::debug($request->path());
            Log::debug($e);
            return abort(500);
        }
    }
}
