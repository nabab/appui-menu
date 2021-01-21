<?php
/** @var $ctrl \bbn\mvc\controller */
$ctrl->add_inc('menu', new \bbn\appui\menu());
if ( !defined('APPUI_MENU_ROOT') ){
  define('APPUI_MENU_ROOT', $ctrl->plugin_url('appui-menu').'/');
}
$ctrl->data['root'] = APPUI_MENU_ROOT;
