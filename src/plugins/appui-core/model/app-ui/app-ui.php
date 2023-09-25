<?php

use bbn\Mvc;
use bbn\Appui\Menu;

$menu = new Menu();
/** @var bbn\Mvc\Model $model The current model */

//$postItButton = $model->get('./button', [], true);
//$postItCp = $model->addController('./main', [], true);
$root = $model->pluginUrl('appui-menu');
$shortcuts = $model->getModel($root . '/shortcuts/list');
$menus = $menu->getMenus();
return [
  'headleft' => [
    'content' => Mvc::getInstance()->subpluginView('app-ui/button', 'html', [], 'appui-menu', 'appui-core'),
    'script' => Mvc::getInstance()->subpluginView('app-ui/button', 'js', [], 'appui-menu', 'appui-core'),
  ],
  'after' => [
    'content' => Mvc::getInstance()->subpluginView('app-ui/menu', 'html', [], 'appui-menu', 'appui-core'),
    'script' => Mvc::getInstance()->subpluginView('app-ui/menu', 'js', [], 'appui-menu', 'appui-core'),
    'data' => [
      'current_menu' => $menu->getDefault(),
      'menus' => count($menus) > 1 ? $menus : [],
    ]
  ],
  'head' => [
    'content' => Mvc::getInstance()->subpluginView('app-ui/fisheye', 'html', [], 'appui-menu', 'appui-core'),
    'script' => Mvc::getInstance()->subpluginView('app-ui/fisheye', 'js', [], 'appui-menu', 'appui-core'),
    'data' => ['shortcuts' => $shortcuts]
  ]
];


