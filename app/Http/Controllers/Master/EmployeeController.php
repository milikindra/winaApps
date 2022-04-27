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


class EmployeeController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "M03";

    public function employeeShow()
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
            ];
            return View('master.employee.employee', $data);
        } catch (\Exception $e) {
            Log::debug(print_r($_POST, TRUE));
            return abort(500);
        }
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
                'void' => $void
            ];
            $url = Config::get('constants.api_url') . '/employee/getList';
            $client = new Client();
            $response = $client->request('POST', $url, ['json' => $post_data]);
            $body = json_decode($response->getBody());
            $table['draw'] = $draw;
            $table['recordsTotal'] = $body->total;
            $table['recordsFiltered'] = $body->recordsFiltered;
            $table['data'] = $body->employee;
            return json_encode($table);
        } catch (\Exception $e) {
            Log::debug($request->path()  . " | " . print_r($_POST, TRUE));

            return abort(500);
        }
    }

    public function employeeAdd(Request $request)
    {
        try {
            $module = $this->module;

            $menu_name = session('user')->menu_name;
            $user_token = session('user')->api_token;

            $data = [
                'title' => 'Tambah ' . $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
            ];

            return view('master.employee.employeeAdd', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());

            return abort(500);
        }
    }

    public function employeeAddSave(Request $request)
    {
        try {
            $user_token = session('user')->api_token;
            $url = Config::get('constants.api_url') . '/employeeAddSave';
            $post_data = [
                'api_token' => $user_token,
                'user_modified' => session('user')->username,
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'employee_id' => $request->input('employee_id'),
                'full_name' => $request->input('full_name'),
                'pob' => $request->input('pob'),
                'dob' => $request->input('dob'),
                'nationality' => $request->input('nationality'),
                'national_id' => $request->input('national_id'),
                'province' => $request->input('province'),
                'city' => $request->input('city'),
                'district' => $request->input('district'),
                'village' => $request->input('village'),
                'address' => $request->input('address'),
                'postal_code' => $request->input('postal_code'),
                'phone' => $request->input('phone'),
                'marital_status' => $request->input('marital_status'),
                'ptkp_type' => $request->input('ptkp_type'),
                'tax_id' => $request->input('tax_id'),
                'join_date' => $request->input('join_date'),
                'user_image' => ($request->hasFile('user_image')) ? "images/users/" : null,
            ];
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $post_data,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
            if (isset($body->result) && $body->result) {
                $temp = [];
                if ($request->file('user_image')) {
                    $filesname = "";
                    $path = 'images/users/';
                    $file = $request->user_image;
                    if (is_file($file)) {
                        $filename = $body->data->employee_id . '.png';
                        $uploaded = $file->move($path, $filename);
                        $filesname = $filename;
                    } else {
                        $filesname = $request->user_image;
                    }
                }

                $data = [
                    'result' => true
                ];
                Alert::toast($body->message, 'success');

                return redirect()->back()->with('success', $body->message);
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
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());

            return abort(500);
        }
    }

    public function employeeDetail($id)
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name;
            $url = Config::get('constants.api_url') . '/getEmployeeById';
            $post_data = [
                'user_id' => session('user')->user_id
            ];
            $client = new Client();
            $response = $client->request('POST', $url, [
                'json' => $post_data,
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
            $data = [
                'title' => $menu_name->$module->module_name,
                'parent_page' => $menu_name->$module->parent_name,
                'page' => $menu_name->$module->module_name,
                'user' => $body->data[0]
            ];
            return View('master.employee.employeeDetail', $data);
        } catch (\Exception $e) {
            Log::debug(print_r($_POST, TRUE));
            return abort(500);
        }
    }

    public function employeeEdit($id)
    {
        dd($id);
    }
}
