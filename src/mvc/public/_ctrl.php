<?php
/** @var $ctrl \bbn\mvc\controller */
$ctrl->add_inc('menu', new \bbn\appui\menus());

$ctrl->data['root'] = $ctrl->plugin_url('appui-menu').'/';
