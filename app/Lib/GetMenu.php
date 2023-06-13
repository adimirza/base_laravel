<?php

namespace App\Lib;

use App\Models\MenuModel;
use App\Models\MenuPermissionModel;

class GetMenu
{
  function getMenus($title)
  {
    // $role = auth()->user()->id_role;
    $role = session()->get('id_role');
    $parent = MenuModel::where('nama', $title)->first();
    $menus = MenuPermissionModel::selectRaw('bs_menu.id as id, parent, bs_menu.nama as nama, uri, url, icon, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("bs_menu.status = 1 AND bs_menu.parent IS NULL AND id_role = $role AND permission = 'read'")->get();

    $html_out = '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';
    $status = '';
    $open = '';
    $url = url('/');
    foreach($menus as $menu){
      if($title == $menu['nama']){
        $status = 'active';
      }
      if($parent['parent']){
        if($parent['parent'] == $menu['id']){
          $open = 'menu-open';
        }
      }
      
      $url = url('/'.$menu['uri']);
      $child = $this->getChilds($menu['id'], $title);
      if(!$child){
        $html_out .= '<li class="nav-item ">
                        <a href="'.$url.'" class="nav-link '.$status.'">
                            <i class="nav-icon '.$menu['icon'].'"></i>
                            <p>
                                '.$menu['nama'].'
                            </p>
                        </a>
                      </li>';
      }else{
        $html_out .= '<li class="nav-item '.$open.'">
                        <a href="'.$url.'" class="nav-link '.$status.'">
                            <i class="nav-icon '.$menu['icon'].'"></i>
                            <p>
                                '.$menu['nama'].'
                            </p>
                            <i class="fas fa-angle-left right"></i>
                        </a>';
        $html_out .= '<ul class="nav nav-treeview">';
        $html_out .= $child;
        $html_out .= '</ul>';
        $html_out .= '</li>';
      }
      $status = '';
      $open = '';
    }
    $html_out .= '</ul>';
    return $html_out;
  }

  function getChilds($parent, $title)
  {
    // $role = auth()->user()->id_role;
    $role = session()->get('id_role');
    $menus_child = MenuPermissionModel::selectRaw('bs_menu.id as id, nama, uri, url, icon, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("bs_menu.status = 1 AND bs_menu.parent = $parent AND id_role = $role AND permission = 'read'")->get();
    $status = '';
    $url = url('/');
    $html_out = '';
    foreach($menus_child as $child){
      if($title == $child['nama']){
        $status = 'active';
      }
      $url = url('/'.$child['uri']);
      $html_out .= '<li class="nav-item">
                        <a href="'.$url.'" class="nav-link '.$status.'">
                            <i class="far fa-circle nav-icon"></i>
                            <p>'.$child['nama'].'</p>
                        </a>
                    </li>';
      $status = '';
    }
    return $html_out;
  }
}
