<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $model \bbn\mvc\model*/
$menu = new \bbn\appui\menus($model->inc->options,  $model->data['prepath'] ?? false);
if ( isset($model->inc->pref) ){
  return $menu->custom_tree('default', $model->inc->pref, $model->data['prepath'] ?? false, [
    'text' => 'title',
    'items' => 'children'
  ]);
}
else{
  return $menu->tree('default', $model->data['prepath'] ?: false);
}