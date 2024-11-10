<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var bbn\Mvc\Model $model */
$menu = new \bbn\Appui\Menu($model->inc->options,  $model->data['prepath'] ?? false);
if ( isset($model->inc->pref) ){
  return $menu->customTree(
    $model->data['menu'] ?? 'default',
    $model->data['prepath'] ?? false
  );
}
else{
  return $menu->tree('default', $model->data['prepath'] ?: false);
}
