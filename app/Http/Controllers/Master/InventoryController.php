<?php

namespace App\Http\Controllers\Master;

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


class InventoryController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "M02";

    public function inventoryShow()
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $kategori = kategoriGetRawData();
            $subKategori = subKategoriGetRawData();
            $merk = merkGetRawData();
            $lokasi = lokasiGetRawData();
            $account = accountGetRawData();
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'kategori' => $kategori,
                'subKategori' => $subKategori,
                'merk' => $merk,
                'lokasi' => $lokasi,
                'account' => $account,
            ];
            return View('master.inventory.inventory', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function populate(Request $request, $void, $kategori, $subkategori)
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
                'subkategori' => $subkategori
            ];
            $url = Config::get('constants.api_url') . '/inventory/getList';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $table['draw'] = $draw;
            $table['recordsTotal'] = $body->total;
            $table['recordsFiltered'] = $body->recordsFiltered;
            $table['data'] = $body->inventory;
            return json_encode($table);
        } catch (\Exception $e) {
            Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

            return abort(500);
        }
    }

    public function inventoryAddSave(Request $request)
    {
        // try {
        $user_token = session('user')->api_token;
        $url = Config::get('constants.api_url') . '/inventoryAddSave';

        $aktif = '';
        if ($request->input('aktif') == 'on') {
            $aktif = 'Y';
        } else if ($request->input('kodeBJ') == 'G') {
            $aktif = 'Y';
        }

        $konsinyansi = '';
        if ($request->input('konsinyansi') == 'on' && $request->input('kodeBJ') != 'G') {
            $konsinyansi = 'Y';
        }

        $harga_jual = 0;
        if ($request->input('harga_jual') != null) {
            $harga_jual = $request->input('harga_jual');
        }
        $isMinus = '';
        if ($request->input('isMinus') == 'on') {
            $isMinus = 'Y';
        } else if ($request->input('kodeBJ') == 'G') {
            $isMinus = 'Y';
        }
        $PPhPs23 = '';
        if ($request->input('PPhPs23') == 'on') {
            $PPhPs23 = 'Y';
        }
        $PPhPs21 = '';
        if ($request->input('PPhPs21') == 'on') {
            $PPhPs21 = 'Y';
        }
        $PPhPs4Ayat2 = '';
        if ($request->input('PPhPs4Ayat2') == 'on') {
            $PPhPs4Ayat2 = 'Y';
        }
        $PPhPs21OP = '';
        if ($request->input('PPhPs21OP') == 'on') {
            $PPhPs21OP = 'Y';
        }
        $post_data = [
            'api_token' => $user_token,
            'creator' => session('user')->username,
            'no_stock' => $request->input('kode'),
            'nm_stock' => $request->input('nama_barang'),
            'sat' => $request->input('satuan'),
            'minstock' => $request->input('stok_minimal'),
            'kategori' => $request->input('kategori'),
            'kategori2' => $request->input('subkategori'),
            'merk' => $request->input('merk'),
            'hrg_beli' => 0,
            'hrg_jual' => $harga_jual,
            'keterangan' => $request->input('keterangan'),
            'aktif' => $aktif,
            'isKonsi' => $konsinyansi,
            'isMinus' => $isMinus,
            'NO_REK1' => $request->input('salesAcc'),
            'NO_REK2' => $request->input('purchaseAcc'),
            'PPhPs23' => $PPhPs23,
            'PPhPs21' => $PPhPs21,
            'PPhPs4Ayat2' => $PPhPs4Ayat2,
            'PPhPs21OP' => $PPhPs21OP,
            'kodeBJ' => $request->input('kodeBJ'),
            'VINTRASID' => $request->input('vintrasId'),
            'no_stockGroup' => $request->input('no_stockGroup'),
            'nm_stockGroup' => $request->input('nm_stockGroup'),
            'qtyGroup' => $request->input('qtyGroup'),
            'satGroup' => $request->input('satGroup')
        ];
        $client = new Client();
        $response = $client->request('POST', $url, [
            'json' => $post_data,
            'http_errors' => false
        ]);
        $body = json_decode($response->getBody());
        if (isset($body->result) && $body->result) {
            $data = [
                'result' => true
            ];
            Alert::toast($body->message, 'success');

            return redirect()->back();
        } else {
            if (!isset($body->result)) {
                $errors = [];
                foreach ($body as $field => $msg) {
                    array_push($errors, $msg[0]);
                }
                return response()->json([
                    'result' => FALSE,
                    'errors' => $errors
                ]);
            } else {
                return response()->json([
                    'result' => FALSE,
                    'message' => $body->message
                ]);
            }
            Alert::toast($body->message, 'danger');
            return redirect()->back();
        }
        // } catch (\Exception $e) {
        //     // Alert::toast("500", 'danger');
        //     Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
        //     return abort(500);
        // }
    }

    public function inventoryEdit(request $request, $inventory)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/inventoryEdit';

            $post_data = [
                'api_token' => $user_token,
                'user' => session('user')->username,
                'no_stock' => $inventory
            ];
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $post_data,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
            return response()->json([
                'result' => $body->result,
                'data' => $body->inv
            ]);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function inventoryUpdate(Request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/inventoryUpdate';
            if ($request->input('aktif') == 'on') {
                $aktif = 'Y';
            } else {
                $aktif = '';
            }

            if ($request->input('konsinyansi') == 'on') {
                $konsinyansi = 'Y';
            } else {
                $konsinyansi = '';
            }
            $harga_jual = 0;
            if ($request->input('harga_jual') != null) {
                $harga_jual = $request->input('harga_jual');
            }
            if ($request->input('isMinusEdit') == 'on') {
                $isMinus = 'Y';
            } else {
                $isMinus = '';
            }
            if ($request->input('PPhPs23Edit') == 'on') {
                $PPhPs23 = 'Y';
            } else {
                $PPhPs23 = '';
            }
            if ($request->input('PPhPs21Edit') == 'on') {
                $PPhPs21 = 'Y';
            } else {
                $PPhPs21 = '';
            }
            if ($request->input('PPhPs4Ayat2Edit') == 'on') {
                $PPhPs4Ayat2 = 'Y';
            } else {
                $PPhPs4Ayat2 = '';
            }
            if ($request->input('PPhPs21OPEdit') == 'on') {
                $PPhPs21OP = 'Y';
            } else {
                $PPhPs21OP = '';
            }
            $post_data = [
                'api_token' => $user_token,
                'creator' => session('user')->username,
                'no_stock' => $request->input('kode'),
                'nm_stock' => $request->input('nama_barang'),
                'sat' => $request->input('satuan'),
                'minstock' => $request->input('stok_minimal'),
                'kategori' => $request->input('kategori'),
                'kategori2' => $request->input('subkategori'),
                'merk' => $request->input('merk'),
                'hrg_jual' => $request->input('harga_jual'),
                'keterangan' => $request->input('keterangan'),
                'aktif' => $aktif,
                'isKonsi' => $konsinyansi,
                'isMinus' => $isMinus,
                'NO_REK1' => $request->input('salesAccEdit'),
                'NO_REK2' => $request->input('purchaseAccEdit'),
                'PPhPs23' => $PPhPs23,
                'PPhPs21' => $PPhPs21,
                'PPhPs4Ayat2' => $PPhPs4Ayat2,
                'PPhPs21OP' => $PPhPs21OP,
                'kodeBJ' => 'I',
                'VINTRASID' => $request->input('vintrasId')
            ];
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $post_data,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
            if (isset($body->result) && $body->result) {
                $data = [
                    'result' => true
                ];
                Alert::toast($body->message, 'success');

                // return redirect()->back()->with('success', $body->message);
                return redirect()->back();
            } else {
                if (!isset($body->result)) {
                    $errors = [];
                    foreach ($body as $field => $msg) {
                        array_push($errors, $msg[0]);
                    }
                    return response()->json([
                        'result' => FALSE,
                        'errors' => $errors
                    ]);
                } else {
                    return response()->json([
                        'result' => FALSE,
                        'message' => $body->message
                    ]);
                }
                Alert::toast($body->message, 'danger');
                return redirect()->back();;
            }
        } catch (\Exception $e) {
            // Alert::toast("500", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());

            return abort(500);
        }
    }

    public function inventoryDelete(request $request, $inventory)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/inventoryDelete';

            $post_data = [
                'api_token' => $user_token,
                'user' => session('user')->username,
                'no_stock' => $inventory
            ];
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $post_data,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
            return response()->json([
                'result' => $body->result,
                'message' => $body->message
            ]);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());

            return abort(500);
        }
    }

    public function kartuStok(Request $request)
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $lokasiRaw = lokasiGetRawData();

            $user_token = session('user')->api_token;


            $item_transfer = '0';
            if ($request->has('item_transfer')) {
                $item_transfer = '1';
            }
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'kode' => $request->input('kode'),
                'lokasi_input' => $request->input('lokasi'),
                'sdate' => $request->input('sdate'),
                'edate' => $request->input('edate'),
                'item_transfer' => $item_transfer,
                'lokasi' => $lokasiRaw,
            ];
            return View('master.inventory.kartuStock', $data);
        } catch (\Exception $e) {
            Log::debug(print_r($_POST, TRUE));
            return abort(500);
        }
    }

    public function kartuStokPopulate(Request $request, $kode, $sdate, $edate, $lokasi, $item_transfer)
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
                'kode' => $kode,
                'sdate' => $sdate,
                'edate' => $edate,
                'lokasi' => $lokasi,
                'item_transfer' => $item_transfer,
            ];

            $url = Config::get('constants.api_url') . '/kartuStok/getList';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $table['draw'] = $draw;
            $table['recordsTotal'] = $body->total;
            $table['recordsFiltered'] = $body->recordsFiltered;
            $table['data'] = $body->kartuStok;
            return json_encode($table);
        } catch (\Exception $e) {
            Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

            return abort(500);
        }
    }
}
