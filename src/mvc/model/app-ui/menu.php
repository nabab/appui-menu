<?php

use bbn\Appui\Menu;
$menu = new Menu();

return [
  'current_menu' => $menu->getDefault(),
  'menus' => count(($m = $menu->getMenus())) > 1 ? $m : [],
];

