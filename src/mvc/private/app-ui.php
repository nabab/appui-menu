<?php

use bbn\X;

$root = $ctrl->pluginUrl('appui-menu');
$shortcuts = $ctrl->getModel($root . '/shortcuts/list');
$button = $ctrl->add($root . '/app-ui/button', [], true);
$menutree = $ctrl->add($root . '/app-ui/menu', [], true);
$fisheye = $ctrl->add($root . '/app-ui/fisheye', [
  'shortcuts' => $shortcuts
], true);
$ctrl->obj->data = [
  'headleft' => $button->obj,
  'after' => $menutree->obj,
  'head' => $fisheye->obj
];


