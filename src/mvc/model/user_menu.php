<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $model \bbn\mvc\model*/
$menu = new \bbn\appui\menus($model->inc->options,  $model->data['prepath'] ?? null);


return $menu->tree($model->data['menu'] ?: 'default', $model->data['prepath'] ?? null);




/* if ( isset($model->inc->pref) ){
  return $menu->custom_tree($model->data['menu'] ?: 'default', $model->inc->pref, $model->data['prepath'] ?? null, [
    'text' => 'title',
    'items' => 'children'
  ]);
}
else{
  return $menu->tree('default', $model->data['prepath'] ?: null);
} */