<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Spipu\Html2Pdf\Html2Pdf;

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
            $nonWapu = getGlobalParam('wapu', 'nonWapu');
            $sWapu = getGlobalParam('wapu', 'sWapu');
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'sales' => $sales,
                'lokasi' => $lokasi,
                'vat' => $vat,
                'sales' => $sales,
                'nonWapu' => $nonWapu,
                'sWapu' => $sWapu,
            ];
            return View('transaction.salesInvoice.salesInvoiceAdd', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function salesInvoiceAddSave(Request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/salesInvoiceAddSave';

            $no_sj = '';
            $no_so_um = '';
            $isUm = '';
            $no_so = '';
            if ($request->input('use_dp') == "on") {
                $no_so_um = $request->input('so_id');
                $isUm = "Y";
            } else {
                $no_so = $request->input('so_id');
                $no_sj = $request->input('do_soum');
            }

            $wapu = '';
            if ($request->input('cek_wapu') == "on") {
                $wapu = "Y";
            }

            $post_attach = [];
            if ($request->file() != null) {
                for ($i = 0; $i < count($request->file('attach')); $i++) {
                    $attach = $request->file('attach')[$i];
                    $post_attach[] = [
                        'module' => 'SI',
                        'extension' => $attach->getClientOriginalExtension(),
                    ];
                }
            }

            $post_head = [
                "api_token" => $user_token,
                "TGL_BUKTI" => $request->input('date_order'),
                "ID_CUST" => $request->input('customer'),
                "NM_CUST" => $request->input('customer_name'),
                "TEMPO" => $request->input('tempo'),
                "ID_SALES" => $request->input('sales'),
                "NM_SALES" => $request->input('sales_name'),
                "KETERANGAN" => $request->input('notes'),
                "CREATOR" => "WINA : " . session('user')->username,
                "EDITOR" => "WINA : " . session('user')->username,
                "rate" => $request->input('rate_cur'),
                "curr" => $request->input('curr'),
                "no_so" => $no_so,
                "alamatkirim" => $request->input('ship_to'),
                "pay_term" => $request->input('payterm'),
                "isUM" => $isUm,
                "no_so_um" => $no_so_um,
                "uangmuka" =>  $request->input('totalDp') != null && $request->input('totalDp') != '' ? (float)str_replace(',', '', $request->input('totalDp')) : 0,
                "totdetail" => (float)str_replace(',', '', $request->input('totalBruto')),
                "uangmuka_ppn" => $request->input('taxDp') != null && $request->input('taxDp') != '' ? (float)str_replace(',', '', $request->input('taxDp')) : 0,
                "ppntotdetail" => $request->input('taxDetail') != null && $request->input('taxDetail') != '' ? (float)str_replace(',', '', $request->input('taxDetail')) : 0,
                "no_pajakF" => $request->input('tax_snF'),
                "no_pajakE" => $request->input('tax_snE'),
                "no_rek" => $request->input('acc_receivable'),
                "isWapu" => $wapu,
                "no_tt" => $request->input('receiced_id'),
                "tgl_tt" => $request->input('received_date'),
                "penerima_tt" => $request->input('received_by'),
                "isSI_UM_FINAL" => $request->input('finalDp'),
                "PPN" =>  $request->input('taxCustomer')
            ];
            $post_detail = [];
            for ($i = 0; $i < count($request->input('no_stock')); $i++) {
                if (!empty($request->input('no_stock'))) {
                    $post_detail[] = [
                        "NO_STOCK" => $request->input('no_stock')[$i],
                        "NM_STOCK" => $request->input('nm_stock')[$i],
                        "QTY" => $request->input('qty')[$i],
                        "SAT" => $request->input('sat')[$i],
                        "HARGA" => (float)str_replace(',', '', $request->input('price')[$i]),
                        "DISC1" => (float)str_replace(',', '', $request->input('disc')[$i]),
                        "DISC2" => (float)str_replace(',', '', $request->input('disc2')[$i]),
                        "DISC3" => 0,
                        "DISCRP" => (float)str_replace(',', '', $request->input('disc_val')[$i]),
                        "discrp2" => '0',
                        "KET" => $request->input('ket')[$i],
                        "id_lokasi" => $warehouse = $request->input('warehouse')[$i],
                        "tax" => $request->input('tax')[$i],
                        "kode_group" => $request->input('itemKodeGroup')[$i],
                        "qty_grup" => '0',
                        "no_sj" => $no_sj,
                        "vintrasId" => $request->input('itemVintrasId')[$i],
                        "vintrasTahun" => $request->input('itemTahunVintras')[$i],
                    ];
                }
            }

            $postData = [
                'head' => $post_head,
                'detail' => $post_detail,
                'attach' => $post_attach
            ];
            $request->request->add(['api_token' => $user_token]);
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $postData,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());

            if ($body->result == true) {
                if ($request->file() != null) {
                    for ($i = 0; $i < count($request->file('attach')); $i++) {
                        $attach = $request->file('attach')[$i];
                        $filename = $body->fname . "-" . ($i + 1) . "." .  $attach->getClientOriginalExtension();
                        Storage::disk('local')->putFileAs('document/SI/' . date_format(date_create($request->input('date_order')), 'Y'), $attach, $filename);
                    }
                }
                Alert::toast($body->message, 'success');
                if ($request->input('process') == 'saveNew') {
                    return redirect()->back();
                } else if ($request->input('process') == 'saveView') {
                    return redirect('salesInvoiceDetail/d/' . base64_encode($body->id));
                } else if ($request->input('process') == 'efaktur') {
                    $ba = $request->input('baEfaktur') != null ? $request->input('baEfaktur') : "void";
                    $bc = $request->input('bcEfaktur') != null ? $request->input('bcEfaktur') : "void";
                    return redirect('efakturGenerator/' . base64_encode($body->id) . '/' . base64_encode($ba) . '/' . base64_encode($bc));
                } else {
                    $urlPrint = 'salesInvoicePrint/' . $request->input('process') . '/' . base64_encode($body->id);
                    // $urlView = 'salesInvoiceDetail/d/' . base64_encode($body->id);
                    echo "<script>window.open('" . $urlPrint . "', '_blank')</script>";
                    // echo "<script>window.open('" . $urlView . "')</script>";
                    // return redirect('salesInvoicePrint/' . $request->input('process') . "/" . base64_encode($body->id));
                    return redirect('salesInvoiceDetail/d/' . base64_encode($body->id));
                }
                // self::salesInvoiceDetail("d", base64_encode($body->id));
            } else {
                Alert::toast($body->message, 'error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Alert::toast("500 - Failed to Save Data", 'error');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back();
        }
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

    public function getDo(Request $request, $so_id, $do_id)
    {
        try {
            $user_token = session('user')->api_token;
            $post_data = [
                'user' => session('user')->username,
                'so_id' => $so_id,
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

    public function getSoDp(Request $request, $so_id, $um_id)
    {
        try {
            $user_token = session('user')->api_token;
            $post_data = [
                'user' => session('user')->username,
                'so_id' => $so_id,
                'um_id' => $um_id,
            ];

            $url = Config::get('constants.api_url') . '/salesInvoice/getSoDp';
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

    public function salesInvoiceDetail($void, $si_id)
    {
        try {
            $user_token = session('user')->api_token;
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $sales = salesGetRawData('ID_SALES', 'ASC');
            $lokasi = lokasiGetRawData();
            $vat = vatGetData(date('Y-m-d'), 'all');
            $url = Config::get('constants.api_url') . '/salesInvoiceDetail';
            $post_data = [
                'api_token' => $user_token,
                'user' => session('user')->username,
                'NO_BUKTI' => base64_decode($si_id),
                'param' => $void
            ];
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $post_data,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());

            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'sales' => $sales,
                'lokasi' => $lokasi,
                'vat' => $vat,
                'sales' => $sales,
                'si' => $body->si,
            ];
            return View('transaction.salesInvoice.salesInvoiceDetail', $data);
        } catch (\Exception $e) {
            Alert::toast("500 - Failed to View Data", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back();
        }
    }

    public function salesInvoicePrint(request $request, $format, $si_id)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/salesInvoiceDetail';

            $post_data = [
                'api_token' => $user_token,
                'user' => session('user')->username,
                'NO_BUKTI' => base64_decode($si_id)
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

            $f = "";
            if ($format == "f2") {
                $f = "_2";
            } else if ($format == "f3") {
                $f = "_3";
            }
            $data = [
                'topManagement' => $topManagement,
                'si' => $body->si,
                'format' => $f
            ];
            // dd($data);
            // $html2pdf = new Html2Pdf('P', 'Letter', 'en', true, 'UTF-8', array(5, 5, 5, 8));
            // $html2pdf->writeHTML(view('transaction.salesInvoice.print.salesInvoice', $data));
            // $html2pdf->writeHTML("A");
            // $html2pdf->output('SI.pdf');
            return View('transaction.salesInvoice.print.salesInvoice', $data);
        } catch (\Exception $e) {
            Alert::toast("500 - Failed to View Data", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back();
        }
    }

    public function salesInvoiceUpdate(Request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/salesInvoiceUpdate';

            $no_sj = '';
            $no_so_um = '';
            $isUm = '';
            $no_so = '';
            if ($request->input('use_dp') == "on") {
                $no_so_um = $request->input('so_id');
                $isUm = "Y";
            } else {
                $no_so = $request->input('so_id');
                $no_sj = $request->input('do_soum');
            }

            $wapu = null;
            if ($request->input('cek_wapu') == "on") {
                $wapu = "Y";
            }


            $post_attach = [];
            if ($request->file() != null) {
                for ($i = 0; $i < count($request->file('attach')); $i++) {
                    $attach = $request->file('attach')[$i];
                    $post_attach[] = [
                        'module' => 'SI',
                        'extension' => $attach->getClientOriginalExtension(),
                    ];
                }
            }

            $post_head = [
                "api_token" => $user_token,
                "si_id" => $request->input('si_id'),
                "TGL_BUKTI" => $request->input('date_order'),
                "ID_CUST" => $request->input('customer'),
                "NM_CUST" => $request->input('customer_name'),
                "TEMPO" => $request->input('tempo'),
                "ID_SALES" => $request->input('sales_id'),
                "NM_SALES" => $request->input('sales_name'),
                "KETERANGAN" => $request->input('notes'),
                // "CREATOR" => "WINA : " . session('user')->username,
                "EDITOR" => "WINA : " . session('user')->username,
                "rate" => $request->input('rate_cur'),
                "curr" => $request->input('curr'),
                "no_so" => $no_so,
                "alamatkirim" => $request->input('ship_to'),
                "pay_term" => $request->input('payterm'),
                "isUM" => $isUm,
                "no_so_um" => $no_so_um,
                "uangmuka" =>  $request->input('totalDp') != null && $request->input('totalDp') != '' ? (float)str_replace(',', '', $request->input('totalDp')) : 0,
                "totdetail" => (float)str_replace(',', '', $request->input('totalBruto')),
                "uangmuka_ppn" => $request->input('taxDp') != null && $request->input('taxDp') != '' ? (float)str_replace(',', '', $request->input('taxDp')) : 0,
                "ppntotdetail" => $request->input('taxDetail') != null && $request->input('taxDetail') != '' ? (float)str_replace(',', '', $request->input('taxDetail')) : 0,
                "no_pajakF" => $request->input('tax_snF'),
                "no_pajakE" => $request->input('tax_snE'),
                "no_rek" => $request->input('acc_receivable'),
                "isWapu" => $wapu,
                "no_tt" => $request->input('receiced_id'),
                "tgl_tt" => $request->input('received_date'),
                "penerima_tt" => $request->input('received_by'),
                "isSI_UM_FINAL" => $request->input('finalDp'),
                "PPN" =>  $request->input('taxCustomer')
            ];
            $post_detail = [];
            for ($i = 0; $i < count($request->input('no_stock')); $i++) {
                if (!empty($request->input('no_stock'))) {
                    $post_detail[] = [
                        "NO_STOCK" => $request->input('no_stock')[$i],
                        "NM_STOCK" => $request->input('nm_stock')[$i],
                        "QTY" => $request->input('qty')[$i],
                        "SAT" => $request->input('sat')[$i],
                        "HARGA" => (float)str_replace(',', '', $request->input('price')[$i]),
                        "DISC1" => (float)str_replace(',', '', $request->input('disc')[$i]),
                        "DISC2" => (float)str_replace(',', '', $request->input('disc2')[$i]),
                        "DISC3" => 0,
                        "DISCRP" => (float)str_replace(',', '', $request->input('disc_val')[$i]),
                        "discrp2" => '0',
                        "KET" => $request->input('ket')[$i],
                        "id_lokasi" => $warehouse = $request->input('warehouse')[$i],
                        "tax" => $request->input('tax')[$i],
                        "kode_group" => $request->input('itemKodeGroup')[$i],
                        "qty_grup" => '0',
                        "no_sj" => $no_sj
                    ];
                }
            }

            $postData = [
                'head' => $post_head,
                'detail' => $post_detail,
                'attach' => $post_attach
            ];

            $request->request->add(['api_token' => $user_token]);
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $postData,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());

            if ($body->result == true) {
                $no_si = str_replace("/", "_", $body->id);
                if ($request->file() != null) {
                    for ($i = 0; $i < count($request->file('attach')); $i++) {
                        $attach = $request->file('attach')[$i];
                        $filename = $no_si . "-" . $i + 1 . "." .  $attach->getClientOriginalExtension();
                        Storage::disk('local')->putFileAs('document/SI/' . date_format(date_create($request->input('date_order')), 'Y'), $attach, $filename);
                    }
                }
                Alert::toast($body->message, 'success');

                if ($request->input('process') != 'save') {
                    return redirect('salesInvoicePrint/' . $request->input('process') . "/" . base64_encode($body->id));
                } else {
                    return redirect('salesInvoiceDetail/d/' . base64_encode($body->id));
                }
            } else {
                // Alert::warning('Update Failed', htmlspecialchars_decode($body->message))->showConfirmButton('Confirm', '#17A2B8');
                if ($body->message->lock == "finance") {
                    Alert::html(
                        'Update Failed',
                        'Unable to update data. <br/>Finance has been locked : ' . date_format(date_create($body->message->dates), 'd-m-Y') . ', change can create different values in the general ledger 
                    <p><br/></p> 
                    <div style="font-size:12px;">
                        <div class="col-12 row" style="text-align:left">From</div>
                        <div  class="col-12 row">
                            <div class="col-5" style="text-align:left">' . $body->message->old[0]->nama_akun . '</div>
                            <div class="col-1" style="text-align:left"></div>
                            <div class="col-5" style="text-align:left">: ' . number_format($body->message->old[0]->debet_rp, 2) . '(D)</div>
                            <div class="col-1" style="text-align:left"></div>
                        </div>
                        <div  class="col-12 row">
                            <div class="col-1" style="text-align:left"></div>
                            <div class="col-5" style="text-align:left">Unbilled</div>
                            <div class="col-1" style="text-align:left">:</div>
                            <div class="col-5" style="text-align:left">' . number_format($body->message->old[0]->kredit_rp, 2) . '(C)</div>
                        </div>
                        <div class="col-12 row" style="text-align:left">To</div>
                        <div  class="col-12 row">
                            <div class="col-5" style="text-align:left">' . $body->message->new[0]->nama_akun . '</div>
                            <div class="col-1" style="text-align:left"></div>
                            <div class="col-5" style="text-align:left">: ' . number_format($body->message->new[0]->debet_rp, 2) . '(D)</div>
                            <div class="col-1" style="text-align:left"></div>
                        </div>
                        <div  class="col-12 row">
                            <div class="col-1" style="text-align:left"></div>
                            <div class="col-5" style="text-align:left">Unbilled</div>
                            <div class="col-1" style="text-align:left">:</div>
                            <div class="col-5" style="text-align:left">' . number_format($body->message->new[0]->kredit_rp, 2) . '(C)</div>
                        </div>
                    </div>
                    ',
                        'error'
                    )->showConfirmButton('Ok', '#17A2B8');
                } else if ($body->message->lock == "inventory") {
                    Alert::html(
                        'Update Failed',
                        'Unable to update data.<br/> Inventory has been locked : ' . date_format(date_create($body->message->dates), 'd-m-Y'),
                        'error'
                    )->showConfirmButton('Ok', '#17A2B8');
                } else {
                    Alert::warning('Update Failed', $body->message)->showConfirmButton('Ok', '#17A2B8');
                }
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Alert::warning('Update Failed', $body->message)->showConfirmButton('Ok', '#17A2B8');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back();
        }
    }

    // public function salesInvoiceStatus(request $request, $si_id)
    // {
    //     $user_token = session('user')->api_token;
    //     $url = Config::get('constants.api_url') . '/salesInvoiceStatus';

    //     $post_data = [
    //         'api_token' => $user_token,
    //         'user' => session('user')->username,
    //         'NO_BUKTI' => $si_id
    //     ];
    //     $client = new Client();
    //     $response = $client->request('POST', $url, [
    //         'json' => $post_data,
    //         'http_errors' => false
    //     ]);
    //     $body = json_decode($response->getBody());
    //     return json_encode($body);
    // }

    public function salesInvoiceDelete(Request $request, $si_id)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/salesInvoiceDelete';

            $post_data = [
                'api_token' => $user_token,
                'user' => 'WINA : ' . session('user')->username,
                'NO_BUKTI' => base64_decode($si_id)
            ];
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $post_data,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());

            foreach ($body->fileLocal as $local) {
                Storage::disk('local')->delete($local->path);
            }
            if ($body->result == true) {
                Alert::toast($body->message, 'success');
                return redirect('salesInvoice');
            } else {
                Alert::toast($body->message, 'danger');
                return redirect('salesInvoiceDetail/d/' . $si_id);
            }
        } catch (\Exception $e) {
            Alert::warning('Error Delete', $body->message)->showConfirmButton('Confirm', '#17A2B8');;
            // Alert::toast('Error delete', 'danger');
            // Log::debug($body->message);
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect('salesInvoiceDetail/d/' . $si_id);
        }
    }

    public function salesinvoiceUpdateReceipt(request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/salesInvoiceupdateReceipt';


            $post_head = [
                "api_token" => $user_token,
                "si_id" => $request->input('si_id'),
                "EDITOR" => "WINA : " . session('user')->username,
                "no_tt" => $request->input('received_id'),
                "tgl_tt" => $request->input('received_date'),
                "penerima_tt" => $request->input('received_by'),
            ];

            $postData = [
                'head' => $post_head,
            ];

            $request->request->add(['api_token' => $user_token]);
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $postData,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
        } catch (\Exception $e) {
            Alert::warning('Update Failed', $body->message)->showConfirmButton('Ok', '#17A2B8');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back();
        }
    }
}
