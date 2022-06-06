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

class SalesOrderController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "T01";

    public function salesOrderShow()
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name;

            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,

            ];
            return View('transaction.salesOrder.salesOrder', $data);
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
            $url = Config::get('constants.api_url') . '/salesOrder/getList';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $table['draw'] = $draw;
            $table['recordsTotal'] = $body->total;
            $table['recordsFiltered'] = $body->recordsFiltered;
            $table['data'] = $body->so;

            return json_encode($table);
        } catch (\Exception $e) {
            Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

            return abort(500);
        }
    }

    public function salesOrderAdd()
    {

        try {
            $user_token = session('user')->api_token;
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $customer = customerGetRawData('NM_CUST', 'ASC');
            $sales = salesGetRawData('ID_SALES', 'ASC');
            $bu = bussinessUnitGetRawData();
            $dept = deptGetRawData();
            $inventory = inventoryGetRawData();
            $vat = vatGetRawData();
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'customer' => $customer,
                'sales' => $sales,
                'bu' => $bu,
                'dept' => $dept,
                'inventory' => $inventory,
                'vat' => $vat,
            ];

            // if ($id != 'add' || empty($id)) {
            //     $url = Config::get('constants.api_url') . '/salesOrderDetail';

            //     $post_data = [
            //         'api_token' => $user_token,
            //         'user' => session('user')->username,
            //         'NO_BUKTI' => $id
            //     ];
            //     $client = new Client();
            //     $response = $client->request('POST', $url, [
            //         'json' => $post_data,
            //         'http_errors' => false
            //     ]);
            //     $body = json_decode($response->getBody());
            //     $data += ['so' => $body->so];
            // }

            return View('transaction.salesOrder.salesOrderAdd', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function salesOrderAddSave(Request $request)
    {
        // dd($request->input());
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/salesOrderAddSave';
            $bu = $request->input("bu");
            $bu_val = 0;
            foreach (array_filter(explode(";", $bu)) as $bus) {
                $bu_split = explode(":", $bus);
                $bu_val += (int)$bu_split[1];
            }
            if ($bu_val > 100) {
                Alert::toast("Nilai Bussiness Unit melebihi 100%", 'danger');
                return redirect()->back();
            } else if ($bu_val < 100) {
                Alert::toast("Nilai Bussiness Unit kurang dari 100%", 'danger');
                return redirect()->back();
            }

            $dept = $request->input("dept");
            $dept_val = 0;
            foreach (array_filter(explode(";", $dept)) as $depts) {
                $dept_split = explode(":", $depts);
                $dept_val += (int)$dept_split[1];
            }
            if ($dept_val > 100) {
                Alert::toast("Nilai Department 100%", 'danger');
                return redirect()->back();
            } else if ($dept_val < 100) {
                Alert::toast("Nilai Department kurang dari 100%", 'danger');
                return redirect()->back();
            }

            $get_urut_detail = soGetLastDetail();

            $post_head = [
                "api_token" => $user_token,
                "NO_BUKTI" => $request->input('nomor'),
                "TGL_BUKTI" => $request->input('date_order'),
                "DIVISI" => $request->input('bu'),
                "ID_CUST" => $request->input('customer'),
                "NM_CUST" => $request->input('customer_name'),
                "TEMPO" => $request->input('tempo'),
                "ID_SALES" => $request->input('sales'),
                "NM_SALES" => $request->input('sales_name'),
                "KETERANGAN" => $request->input('notes'),
                "CREATOR" => session('user')->username,
                "EDITOR" => session('user')->username,
                "rate" => $request->input('rate_cur'),
                "curr" => $request->input('curr'),
                "dept" => $request->input('dept'),
                "DIVISI" => $request->input('bu'),
                "PO_CUST" => $request->input('po_customer'),
                "attn" => $request->input('attn'),
                "pay_term" => $request->input('payterm'),
                "discH" => $request->input('discountProcentageHead'),
                "no_ref" => $request->input('quotation_ref'),
                "alamatkirim" => $request->input('ship_to'),
                "jenis" => $request->input('jenis'),
                "totdetail" => $request->input('totalBruto'),
                "rp_disch" => $request->input('discountValueHead'),
                "ppntotdetail" => (float)$request->input('totalBruto') - (float)$request->input('discountValueHead'),
                "uangmuka" => $request->input('totalDp'),
                "uangmuka_ppn" => $request->input('totalDpTax')
            ];

            $post_detail = [];
            for ($i = 0; $i < count($request->input('no_stock')); $i++) {
                if (!empty($request->input('no_stock'))) {
                    $post_detail[] = [
                        "NO_BUKTI" => $request->input('nomor'),
                        "NO_STOCK" => $request->input('no_stock')[$i],
                        "NM_STOCK" => $request->input('no_stock')[$i],
                        "QTY" => $request->input('qty')[$i],
                        "SAT" => $request->input('sat')[$i],
                        "HARGA" => $request->input('price')[$i],
                        "DISC1" => $request->input('disc')[$i],
                        "DISC2" => $request->input('disc2')[$i],
                        "DISC3" => 0,
                        "DISCRP" => $request->input('disc_val')[$i],
                        "discrp2" => '0',
                        "state" => '',
                        "alasan" => '',
                        "nourut" => $get_urut_detail->nourut + 1,
                        "tax" => $request->input('tax')[$i],
                        "kode_group" => '',
                        "qty_grup" => '0',
                        "VINTRASID" => '',
                        "tahun" => ''
                    ];
                }
            }
            $post_dp = [];
            for ($i = 0; $i < count($request->input('dp')); $i++) {
                if (!empty($request->input('dp')[$i]) || !empty($request->input('dp_val')[$i])) {
                    $post_dp[] = [
                        "NO_BUKTI" => $request->input('nomor'),
                        "keterangan" => $request->input('dp')[$i],
                        "nilai" => $request->input('dp_value')[$i],
                        // "idxurut" => '',
                        "nourut" => $i + 1,
                        "tax" => $request->input('dp_tax')[$i],
                    ];
                }
            }


            $postData = ['head' => $post_head, 'detail' => $post_detail, 'um' => $post_dp];
            $request->request->add(['api_token' => $user_token]);
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $postData,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
            $data = [
                'result' => true
            ];
            Alert::toast($body->message, 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast("500", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());

            return abort(500);
        }
    }

    public function salesOrderDetail(request $request, $so_id)
    {
        // try {
        $user_token = session('user')->api_token;
        $url = Config::get('constants.api_url') . '/salesOrderDetail';

        $post_data = [
            'api_token' => $user_token,
            'user' => session('user')->username,
            'NO_BUKTI' => $so_id
        ];
        $client = new Client();
        $response = $client->request('POST', $url, [
            'json' => $post_data,
            'http_errors' => false
        ]);
        $body = json_decode($response->getBody());

        $module = $this->module;
        $menu_name = session('user')->menu_name;
        $customer = customerGetRawData('NM_CUST', 'ASC');
        $sales = salesGetRawData('ID_SALES', 'ASC');
        $bu = bussinessUnitGetRawData();
        $dept = deptGetRawData();
        $inventory = inventoryGetRawData();
        $vat = vatGetRawData();

        $data = [
            'title' => $menu_name->$module->module_name,
            'parent_page' => $menu_name->$module->parent_name,
            'page' => $menu_name->$module->module_name,
            'customer' => $customer,
            'sales' => $sales,
            'bu' => $bu,
            'dept' => $dept,
            'inventory' => $inventory,
            'vat' => $vat,
            'so' => $body->so,
        ];
        return View('transaction.salesOrder.salesOrderDetail', $data);
        // } catch (\Exception $e) {
        //     Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
        //     return abort(500);
        // }
    }
}
