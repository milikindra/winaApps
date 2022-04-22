<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Employee;


class EmployeeController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "M03";

    public function employeeShow()
    {
        try {
            $module = $this->module;
            $menu_name = session('user')->menu_name->toArray();
            $data = [
                'title' => $menu_name[$module]['module_name'],
                'parent_page' => $menu_name[$module]['parent_name'],
                'page' => $menu_name[$module]['module_name'],
            ];
            return View('master.employee.employee', $data);
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());

            return abort(500);
        }
    }

    public function populate(Request $request, $void)
    {
        // try {
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
        $req = Employee::getPopulateEmployee('1');
        $filteredData = $req->get();
        $totalRows = $req->count();

        $table['draw'] = $draw;
        $table['recordsTotal'] = $totalRows;
        $table['recordsFiltered'] = count($filteredData);
        $table['data'] = $req->get();

        return json_encode($table);
        // } catch (\Exception $e) {
        //     Log::debug($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());

        //     return abort(500);
        // }
    }
}
