<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var bbn\Mvc\Model $model */
$menu = new \bbn\Appui\Menu();
$shortcuts = $menu->shortcuts();
if ( !empty($model->data['prepath']) ){
  $prepath = $model->data['prepath'];
  return array_map(function($a) use($prepath){
    if ( strpos($a['url'], $prepath) === 0 ){
      $a['url'] = substr($a['url'], \strlen($prepath)+1);
    }
    return $a;
  }, $shortcuts);
}
return $shortcuts;
