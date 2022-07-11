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

class VintrasController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $module = "M07";

    public function populate(Request $request, $period)
    {
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
            'period' => $period,
        ];
        $url = Config::get('constants.api_url') . '/vintras/getList';
        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $post_data]);
        $body = json_decode($response->getBody());
        $table['draw'] = $draw;
        $table['recordsTotal'] = $body->total;
        $table['recordsFiltered'] = $body->recordsFiltered;
        $table['data'] = $body->vintras;
        return json_encode($table);
    }
}
