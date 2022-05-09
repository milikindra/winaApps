<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Tree\ModuleNode;

$activeMenu = "";

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
