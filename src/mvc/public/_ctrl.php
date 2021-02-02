<?php
/** @var $ctrl \bbn\Mvc\Controller */
$ctrl->addInc('menu', new \bbn\Appui\Menu());
if ( !defined('APPUI_MENU_ROOT') ){
  define('APPUI_MENU_ROOT', $ctrl->pluginUrl('appui-menu').'/');
}
$ctrl->data['root'] = APPUI_MENU_ROOT;
