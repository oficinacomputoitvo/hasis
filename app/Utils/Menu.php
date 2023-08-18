<?php
namespace App\Utils;

class Menu {

        private static function menuId($menu=""){
            return ("menu". ucfirst(str_replace(' ', '', $menu)));

        }


        public static function generateInHTMLTag($json, $class_ul='<ul class="navbar-nav submenu">'){
        $menu=$class_ul ;
        foreach($json as $item) {
            $class_li=' class="submenu" ';
            $span= $item->text;
            $attributes_a=' class="submenu" ';
            $menuId = self::menuId($item->text);
            if (count($item->children) > 0){
              $class_li = ' class="dropdown submenu"';
              $span = '<span>' . $item->text . ' </span> ';
              $attributes_a = ' class="nav-link dropdown-toggle submenu"  data-mdb-toggle="dropdown"
              aria-expanded="false" data-bs-toggle="dropdown"  role="button" id="' . $menuId . '"';

            }
            $icon = ' <span><i class="' . $item->icon. '" aria-hidden="true"></i> ';
            $menu.='<li' . $class_li .  '><a href="' . $item->href . '" ' . 
                $attributes_a . '> ' . 
                $icon . $span . '</a>' ;
            if (count($item->children) > 0) {
                $class_ul= '<ul class="dropdown-menu submenu" ' .
                ' aria-labelledby="' . $menuId . '" >';
                $menu.= Menu::generateInHTMLTag($item->children,$class_ul);
            }
            $menu.="</li>";
  
        }
        $menu.="</ul>";
  
        return $menu;
    }
}
?>