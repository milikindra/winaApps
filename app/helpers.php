<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
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
    $menu = array();
    $userid = session('user')->user_id;

    $module = DB::select("call wina_sp_get_module_user ('$userid')");
    $module = collect($module)->keyBy('module_id')->toArray();
    $moduleParent = DB::select("call wina_sp_get_module_user_parent ('$userid')");

    $level = 0;
    $list = [];
    $menu = [];
    foreach ($moduleParent as $node) {
        $tree = new ModuleNode($node->module_id, $module, $level);
        $tree->addChildren($module, $node->module_id, $list);
        array_push($menu, $tree);
    }

    return json_encode($menu);
}

function createMenu($page, $parent_page)
{
    $matrix = json_decode(getMenu());
    // hanya untuk home karena tidak ada di matrix
    $activeHome = '';
    if (strtolower($page) == 'home') {
        $activeHome = 'active';
    }
    $menu = '<li class="nav-item ' . $activeHome . '">
                <a class="nav-link" href="' . url('home') . '">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <i class="ti ti-home"></i>
                    </span>
                    <span class="nav-link-title">
                        Home
                    </span>
                </a>
            </li>';
    // dimuali perulangan matrix menu
    foreach ($matrix as $parent) {
        $module_name = $parent->module_name;
        $activeParent = '';
        if (strtolower($parent_page) === strtolower($module_name)) {
            $activeParent = 'active';
        }
        $iconParent = '';
        if (isset($parent->icon_class)) {
            $iconParent = '<span class="nav-link-icon d-md-none d-lg-inline-block"> <i class="' . $parent->icon_class . '"></i> </span>';
        }

        $menuChild = '';
        foreach ($parent->children as $child) {
            $activeChild = '';
            if (strtolower($page) === strtolower($child->module_name)) {
                $activechild = 'active';
            }
            if ($child->route == null) {
                $child->route = '.';
            }

            $menuChild .= '<a class="dropdown-item ' . $activeChild . '" href="' . url($child->route) . '" > ' . $child->module_name . ' </a>';
        }

        $sub = '<div class="dropdown-menu"> <div class="dropend">' . $menuChild . '</div></div>';

        $menu .= '<li class="nav-item dropdown ' . $activeParent . '">';
        $menu .= '<a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">' . $iconParent;
        $menu .= '<span class="nav-link-title">' . $module_name . '</span>';
        $menu .= '</a>';
        $menu .= $sub;
        $menu .= '</li>';
    }
    echo $menu;
}
