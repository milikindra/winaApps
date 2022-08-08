<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Tree\ModuleNode;

$activeMenu = "";

function hasAccess($code, $wh = null)
{
    $user_access = session('user')->user_access;
    if ($wh == null) {
        foreach ($user_access as $u) {
            if ($u->module_function_id == $code)
                return true;
        }
        return false;
    } else {
        foreach ($user_access as $u) {
            if ($u->module_function_id == $code)
                //TODO: address this security hole, user A dpt akses R01 wh 001, tp dia replace 001 jd 'all' -> bisa
                if ($wh == "all" || $u->warehouse_id == $wh)
                    return true;
        }
        return false;
    }
}

function getIntFromString($input)
{
    return ((int)(preg_replace('/[^0-9]+/', '', $input)));
}

function getVersion() //menghindari caching di js
{
    return rand(1, 100000);
}

function tanggal_indo($tanggal)
{
    $bulan = array(
        1 => 'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agus',
        'Sep',
        'Okt',
        'Nov',
        'Des'
    );
    $split = explode('-', $tanggal);
    return $split[2] . '-' . $bulan[(int)$split[1]] . '-' . $split[0];
}

function accDollars($value)
{
    if ($value < 0) {
        return "(" . accDollars(-$value) . ")";
    } else {
        return number_format($value, 2);
    }
}


// function accPercent($value)
// {
//     if ($value < 0) {
//         return "(" . accPercent(-$value) . ")";
//     } else {
//         return number_format($value, 2) . "";
//     }
// }

function getMenu()
{
    $user_token = session('user')->api_token;
    // belum di pindah ke session, kalo bisa di pindah ke session aja biar lebih ringan tidak load terus tiap ganti halaman
    $matrixUrl = Config::get("constants.api_url") . "/employee/getMenu";
    $jsone = array(
        "api_token" => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();

    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = $responseNumber->getBody();
    return $moduleBody;
}

function createMenu($page, $parent_page)
{
    $matrix = json_decode(getMenu());
    // hanya untuk home karena tidak ada di matrix
    $activeHome = '';
    if (strtolower($page) == 'home') {
        $activeHome = 'active';
    }
    $menu = '<li class="nav-item ">
                <a class="nav-link ' . $activeHome . '" href="' . url('home') . '">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                        Home
                    </p>
                </a>
            </li>';
    // dimuali perulangan matrix menu
    foreach ($matrix as $parent) {
        $module_name = $parent->module_name;
        $activeParent = 'active';
        if (strtolower($parent_page) != strtolower($module_name)) {
            $activeParent = '';
        }
        $iconParent = '';
        if (isset($parent->icon_class)) {
            $iconParent = '<span class="nav-link-icon d-md-none d-lg-inline-block"> <i class="nav-icon ' . $parent->icon_class . '"></i> </span>';
        }

        $menuChild = '';
        foreach ($parent->children as $child) {
            $activeChild = 'active';
            if (strtolower($page) != strtolower($child->module_name)) {
                $activeChild = '';
            }
            if ($child->route == null) {
                $child->route = '.';
            }

            $menuChild .= '<li class="nav-item">
                            <a class="nav-link ' . $activeChild . '" 
                                href="' . url($child->route) . '" >
                                    <i class="far fa-circle nav-icon"></i> <p>' . $child->module_name . ' </p></a></li>';
        }

        $sub = '<ul class="nav nav-treeview">' . $menuChild . '</ul>';

        $menu .= '<li class="nav-item ">';
        $menu .= '<a href="#" class="nav-link ' . $activeParent . '">' . $iconParent;
        $menu .= '<p>' . $module_name . '<i class="right fas fa-angle-left"></i></p>';
        $menu .= '</a>';
        $menu .= $sub;
        $menu .= '</li>';
    }
    echo $menu;
}

function areaGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/areaGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function kategoriGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/kategoriGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function subKategoriGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/subKategoriGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function merkGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/merkGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function lokasiGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/lokasiGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function coaGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/accountGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}


function inventoryGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/inventoryGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function customerGetRawData($field, $sort)
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/customerGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id,
        'field' => $field,
        'sort' => $sort,

    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function customerGetById($id)
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/customerGetById';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id,
        'id_cust' => $id,
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function customerGetBySi($id)
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/customerGetForSi';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id,
        'id_cust' => $id,
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function salesGetRawData($field, $sort)
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/salesGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id,
        'field' => $field,
        'sort' => $sort,

    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function bussinessUnitGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/bussinessUnitGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function deptGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/deptGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function vatGetData($sdate, $flag)
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/vatGetData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id,
        'sdate' => $sdate,
        'flag' => $flag
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function soGetLastDetail()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/soGetLastDetail';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function siGetEfaktur($id)
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/siGetEfaktur';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id,
        'no_bukti2' => $id,
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function employeeGetRawData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/employeeGetRawData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function trxTypeFromGlCard()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/trxTypeFromGlCard';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

// function getTrlProject($so_id)
// {
//     $user_token = session('user')->api_token;
//     $matrixUrl = Config::get('constants.api_url') . '/getTrlProject';
//     $jsone = array(
//         'api_token' => $user_token,
//         'user_id' => session('user')->user_id,
//         'so_id' => 
//     );
//     $numberClient = new Client();
//     $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
//     $moduleBody = json_decode($responseNumber->getBody());

//     return $moduleBody;
// }

function getGlobalParam($category, $id)
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/getGlobalParam';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id,
        'category' => $category,
        'id' => $id,
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function vintrasGetData()
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/vintrasGetData';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id,
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}

function customerBranchGetById($id)
{
    $user_token = session('user')->api_token;
    $matrixUrl = Config::get('constants.api_url') . '/customerBranchGetById';
    $jsone = array(
        'api_token' => $user_token,
        'user_id' => session('user')->user_id,
        'id_cust' => $id,
    );
    $numberClient = new Client();
    $responseNumber = $numberClient->request('POST', $matrixUrl, ['json' => $jsone]);
    $moduleBody = json_decode($responseNumber->getBody());

    return $moduleBody;
}
