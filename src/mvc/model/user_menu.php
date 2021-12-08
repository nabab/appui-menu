<?php
/*
 * Describe what it does
 *
 **/

/** @var $model \bbn\Mvc\Model*/
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
