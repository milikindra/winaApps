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

use App\Models\Employee;


class CustomerController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "M04";

    public function customerShow()
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $sales = salesGetRawData('ID_SALES', 'ASC');
            $area = areaGetRawData();
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'sales' => $sales,
                'area' => $area,
            ];
            return View('master.customer.customer', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }
    public function customerGetById(request $request, $id)
    {
        if ($id != 'all') {
            $data = customerGetById($id);
        } else {
            $data =  customerGetRawData('NM_CUST', 'ASC');
        }
        return json_encode($data);
    }

    public function customerGetForSi(request $request, $id)
    {
        $data = customerGetBySi($id);
        return json_encode($data);
    }

    public function populate(Request $request, $void)
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
            ];
            $url = Config::get('constants.api_url') . '/customer/getList';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $table['draw'] = $draw;
            $table['recordsTotal'] = $body->total;
            $table['recordsFiltered'] = $body->recordsFiltered;
            $table['data'] = $body->customer;
            return json_encode($table);
        } catch (\Exception $e) {
            Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

            return abort(500);
        }
    }

    public function customerAddSave(Request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/customerAddSave';
            $aktif = '';
            if ($request->input('aktif') == 'on') {
                $aktif = 'Y';
            }
            $wapu = '';
            if ($request->input('wapu') == 'on') {
                $wapu = 'Y';
            }
            $berikat = '';
            if ($request->input('berikat') == 'on') {
                $berikat = 'Y';
            }

            $post_customer = [
                'ID_CUST' => $request->input('kode'),
                'NM_CUST' => $request->input('full_name'),
                'ALAMAT1' => $request->input('address'),
                'TELP' => $request->input('telp'),
                'FAX' => $request->input('fax'),
                'TEMPO' => $request->input('tempo'),
                'PLAFON' => $request->input('limit'),
                'AKTIF' => $aktif,
                'NO_NPWP' => $request->input('tax_number'),
                'AREA' => $request->input('area'),
                'ID_SALES' => $request->input('sales'),
                'tipeCustomer' => $request->input('type'),
                'tipeCustomer' => $request->input('type'),
                'CREATOR' => session('user')->username,
                'EDITOR' => session('user')->username,
                'al_fac' => $request->input('address_company'),
                'kecamatan_fac' => $request->input('district_company'),
                'kabupaten_fac' => $request->input('city_company'),
                'propinsi_fac' => $request->input('province_company'),
                'telp_fac' => $request->input('phone_company'),
                'fax_fac' => $request->input('fax_company'),
                'nama_npwp' => $request->input('tax_name'),
                'al_npwp' => $request->input('tax_address'),
                'usaha' => $request->input('type_of_bussiness'),
                'keterangan' => $request->input('description_bussiness'),
                'curr' => $request->input('curr'),
                'isWapu' => $wapu,
                'KodePajak' => $request->input('tax_code'),
                'no_ktp' => $request->input('tax_nationalityId'),
                'isBerikat' => $berikat,
                'alias' => $request->input('alias'),
            ];

            $post_branch = [];
            if ($request->has('branch_name')) {
                for ($i = 0; $i < count($request->input('branch_name')); $i++) {
                    $post_branch[] = [
                        "customer_id" => $request->input('kode'),
                        "address_alias" => $request->input('branch_name')[$i],
                        "other_address" => $request->input('branch_address')[$i],
                        "tax_number" => $request->input('branch_tax_number')[$i],
                        'user_modified' => session('user')->username,
                    ];
                }
            }

            $postData = [
                'customer' => $post_customer,
                'branch' => $post_branch
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
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast("500", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function customerEdit(Request $request, $kode)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/customerEdit';

            $post_data = [
                'api_token' => $user_token,
                'user' => session('user')->username,
                'ID_CUST' => $kode
            ];
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $post_data,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
            return response()->json([
                'result' => $body->result,
                'data' => $body->customer,
                'branch' => $body->branch
            ]);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return abort(500);
        }
    }

    public function customerUpdate(Request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/customerUpdate';
            $aktif = '';
            if ($request->input('aktif') == 'on') {
                $aktif = 'Y';
            }
            $wapu = '';
            if ($request->input('wapu') == 'on') {
                $wapu = 'Y';
            }
            $berikat = '';
            if ($request->input('berikat') == 'on') {
                $berikat = 'Y';
            }

            $post_customer = [
                'ID_CUST_OLD' => $request->input('kodeOld'),
                'ID_CUST' => $request->input('kode'),
                'NM_CUST' => $request->input('full_name'),
                'ALAMAT1' => $request->input('address'),
                'TELP' => $request->input('telp'),
                'FAX' => $request->input('fax'),
                'TEMPO' => $request->input('tempo'),
                'PLAFON' => $request->input('limit'),
                'AKTIF' => $aktif,
                'NO_NPWP' => $request->input('tax_number'),
                'AREA' => $request->input('area'),
                'ID_SALES' => $request->input('sales'),
                'tipeCustomer' => $request->input('type'),
                'tipeCustomer' => $request->input('type'),
                'CREATOR' => session('user')->username,
                'EDITOR' => session('user')->username,
                'al_fac' => $request->input('address_company'),
                'kecamatan_fac' => $request->input('district_company'),
                'kabupaten_fac' => $request->input('city_company'),
                'propinsi_fac' => $request->input('province_company'),
                'telp_fac' => $request->input('phone_company'),
                'fax_fac' => $request->input('fax_company'),
                'nama_npwp' => $request->input('tax_name'),
                'al_npwp' => $request->input('tax_address'),
                'usaha' => $request->input('type_of_bussiness'),
                'keterangan' => $request->input('description_bussiness'),
                'curr' => $request->input('curr'),
                'isWapu' => $wapu,
                'KodePajak' => $request->input('tax_code'),
                'no_ktp' => $request->input('tax_nationalityId'),
                'isBerikat' => $berikat,
                'alias' => $request->input('alias'),
            ];

            $post_branch = [];
            if ($request->input('branch_name') != null) {
                for ($i = 0; $i < count($request->input('branch_name')); $i++) {
                    $post_branch[] = [
                        "customer_id" => $request->input('kode'),
                        "address_alias" => $request->input('branch_name')[$i],
                        "other_address" => $request->input('branch_address')[$i],
                        "tax_number" => $request->input('branch_tax_number')[$i],
                        'user_modified' => session('user')->username,
                    ];
                }
            }

            $where = ['ID_CUST' => $request->input('kodeOld')];
            $postData = [
                'customer' => $post_customer,
                'branch' => $post_branch,
                'where' => $where,
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
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast("500 - Failed to Update Data", 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back();
        }
    }

    public function addBranch(Request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/customerAddBranch';
            $post_branch = [
                "customer_id" => $request['id_cust'],
                "address_alias" => $request['branch_name'],
                "other_address" => $request['branch_address'],
                "tax_number" => $request['branch_tax'],
                'user_modified' => session('user')->username,
            ];
            $postData = [
                'branch' => $post_branch
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
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
        }
    }

    public function customerDelete(Request $request, $id)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/customerDelete';

            $post_data = [
                'api_token' => $user_token,
                'user' => session('user')->username,
                'ID_CUST' => $id
            ];
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $post_data,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
            if ($body->result == true) {
                Alert::toast($body->message, 'success');
            } else {
                Alert::toast($body->message, 'danger');
            }
            return redirect('customer');
        } catch (\Exception $e) {
            Alert::toast('Error delete', 'danger');
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect('customer');
        }
    }
}
