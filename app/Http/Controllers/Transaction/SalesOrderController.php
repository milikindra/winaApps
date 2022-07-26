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
use Spipu\Html2Pdf\Html2Pdf;


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
            $sales = salesGetRawData('ID_SALES', 'ASC');
            $bu = bussinessUnitGetRawData();
            $dept = deptGetRawData();
            $inventory = inventoryGetRawData();
            $vat = vatGetRawData();
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'sales' => $sales,
                'bu' => $bu,
                'dept' => $dept,
                'inventory' => $inventory,
                'vat' => $vat,
            ];
            return View('transaction.salesOrder.salesOrderAdd', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function salesOrderAddSave(Request $request)
    {
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

            $post_customer = [
                'address_alias' => $request->input('cmbShipping'),
                'other_address' => $request->input('ship_to'),
            ];
            $post_head = [
                "api_token" => $user_token,
                "NO_BUKTI" => $request->input('nomor'),
                "TGL_BUKTI" => $request->input('date_order'),
                "tgl_due" => $request->input('date_due'),
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
                "totdetail" => (float)str_replace(',', '', $request->input('totalBruto')),
                "rp_disch" => $request->input('discountValueHead'),
                "ppntotdetail" => (float)str_replace(',', '', $request->input('totalBruto')) - (float)str_replace(',', '', $request->input('discountValueHead')),
                "uangmuka" => (float)str_replace(',', '', $request->input('totalDp')),
                "uangmuka_ppn" => (float)str_replace(',', '', $request->input('totalDpTax'))
            ];

            $post_detail = [];
            for ($i = 0; $i < count($request->input('no_stock')); $i++) {
                if (!empty($request->input('no_stock'))) {
                    $post_detail[] = [
                        "NO_BUKTI" => $request->input('nomor'),
                        "NO_STOCK" => $request->input('no_stock')[$i],
                        "NM_STOCK" => $request->input('nm_stock')[$i],
                        "QTY" => $request->input('qty')[$i],
                        "KET" => $request->input('ket')[$i],
                        "SAT" => $request->input('sat')[$i],
                        "HARGA" => (float)str_replace(',', '', $request->input('price')[$i]),
                        "DISC1" => (float)str_replace(',', '', $request->input('disc')[$i]),
                        "DISC2" => (float)str_replace(',', '', $request->input('disc2')[$i]),
                        "DISC3" => 0,
                        "DISCRP" => (float)str_replace(',', '', $request->input('disc_val')[$i]),
                        "discrp2" => '0',
                        "state" => '',
                        "alasan" => '',
                        "nourut" => $get_urut_detail->nourut + 1,
                        "tax" => $request->input('tax')[$i],
                        "kode_group" => '',
                        "qty_grup" => '0',
                        "VINTRASID" =>  $request->input('itemVintrasId')[$i],
                        "tahun" =>  $request->input('itemTahunVintras')[$i],
                        "kode_group" => $request->input('itemKodeGroup')[$i],
                        "merk" => $request->input('merkItem')[$i]
                    ];
                }
            }
            $post_dp = [];
            for ($i = 0; $i < count($request->input('dp')); $i++) {
                if (!empty($request->input('dp')[$i]) || !empty($request->input('dp_val')[$i])) {
                    $post_dp[] = [
                        "NO_BUKTI" => $request->input('nomor'),
                        "keterangan" => $request->input('dp')[$i],
                        "nilai" => (float)str_replace(',', '', $request->input('dp_value')[$i]),
                        "nourut" => $i + 1,
                        "tax" => $request->input('dp_tax')[$i],
                    ];
                }
            }

            $postData = [
                'head' => $post_head,
                'detail' => $post_detail,
                'um' => $post_dp,
                'customer' => $post_customer
            ];
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
            if ($request->input('process') == 'print') {
                return redirect('salesOrderPrint/' . $request->input('nomor'));
            } else {
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Alert::toast("500 - Failed to Save Data", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back();
            // return abort(500);
        }
    }

    public function salesOrderUpdate(Request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/salesOrderUpdate';
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
                "tgl_due" => $request->input('date_due'),
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
                        "NM_STOCK" => $request->input('nm_stock')[$i],
                        "QTY" => $request->input('qty')[$i],
                        "KET" => $request->input('ket')[$i],
                        "SAT" => $request->input('sat')[$i],
                        "HARGA" => $request->input('price')[$i],
                        "DISC1" => $request->input('disc')[$i],
                        "DISC2" => $request->input('disc2')[$i],
                        "DISC3" => '0.00',
                        "DISCRP" => $request->input('disc_val')[$i],
                        "discrp2" => '0.00',
                        "state" => '',
                        "alasan" => '',
                        "nourut" => $i + 1,
                        "tax" => $request->input('tax')[$i],
                        "kode_group" => '',
                        "qty_grup" => '0.00',
                        "VINTRASID" =>  $request->input('itemVintrasId')[$i],
                        "tahun" =>  $request->input('itemTahunVintras')[$i],
                        "kode_group" => $request->input('itemKodeGroup')[$i],
                        "merk" => $request->input('merkItem')[$i]
                    ];
                }
            }
            $post_dp = [];
            if ($request->has('dp')) {
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
            }

            $where = ['id' => $request->input('nomor_old')];

            $postData = ['head' => $post_head, 'detail' => $post_detail, 'um' => $post_dp, 'where' => $where];
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
            if ($request->input('process') == 'print') {
                return redirect('salesOrderPrint/' . $request->input('nomor'));
            } else {
                return redirect('salesOrderDetail/' . $request->input('nomor'));
            }
        } catch (\Exception $e) {
            Alert::toast("500 - Failed to Update Data", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back();
        }
    }

    public function salesOrderPrint(request $request, $so_id)
    {
        try {
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
            $topManagement = getGlobalParam('top_management', 'all');

            $data = [
                'topManagement' => $topManagement,
                'so' => $body->so,
            ];
            // dd($data);
            // $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 8));
            // $html2pdf->writeHTML(view('transaction.salesOrder.print.salesOrder', $data));
            // $html2pdf->output('SO.pdf', 'D');


            return View('transaction.salesOrder.print.salesOrder', $data);
        } catch (\Exception $e) {
            Alert::toast("500 - Failed to View Data", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back();
        }
    }


    public function salesOrderStatus(request $request, $so_id)
    {
        $user_token = session('user')->api_token;
        $url = Config::get('constants.api_url') . '/salesOrderStatus';

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
        return json_encode($body);
    }

    public function salesOrderDelete(Request $request, $so_id)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/salesOrderDelete';

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
            if ($body->result == true) {
                Alert::toast($body->message, 'success');
                return redirect('salesOrder');
            } else {
                Alert::toast($body->message, 'danger');
                return redirect('salesOrderDetail/' . $so_id);
            }
        } catch (\Exception $e) {
            Alert::toast('Error delete', 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect('salesOrderDetail/' . $so_id);
        }
    }

    public function salesOrderDetail(request $request, $so_id)
    {
        try {
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
            $id_cust = $body->so->head[0]->ID_CUST;
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $customer = customerGetRawData('NM_CUST', 'ASC');
            $sales = salesGetRawData('ID_SALES', 'ASC');
            $bu = bussinessUnitGetRawData();
            $dept = deptGetRawData();
            $inventory = inventoryGetRawData();
            $vat = vatGetRawData();
            $branch = customerBranchGetById($id_cust);

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
                'branch' => $branch
            ];
            return View('transaction.salesOrder.salesOrderDetail', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function populateHead(Request $request)
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
            $url = Config::get('constants.api_url') . '/salesOrder/getlistHead';
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

    public function salesOrderUpdateState(request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/salesOrderUpdateState';

            $post = [
                "state" => $request->input('state'),
                "alasan" => $request->input('noteState'),
                "qty" => $request->input('qty')
            ];
            $where = ['NO_BUKTI' => $request->input('so'), 'NO_STOCK' => $request->input('item')];

            $postData = ['post' => $post, 'where' => $where];
            $request->request->add(['api_token' => $user_token]);
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $postData,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
            Alert::toast($body->message, $body->result);
            return $body;
        } catch (\Exception $e) {
            Alert::toast("500 - Failed to Update Data", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return false;
        }
    }
}
