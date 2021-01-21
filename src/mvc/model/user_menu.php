<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $model \bbn\mvc\model*/
$menu = new \bbn\appui\menu($model->inc->options,  $model->data['prepath'] ?? false);

if ( isset($model->inc->pref) ){
  return $menu->custom_tree(
    $model->data['menu'] ?: 'default',
    $model->data['prepath'] ?? false
  );
}
else{
  return $menu->tree('default', $model->data['prepath'] ?: false);
}
