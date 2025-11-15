<?php
/*
 * Describe what it does or you're a pussy
 *
 **/
use bbn\Str;

/** @var bbn\Mvc\Model $model */
$menu = new \bbn\Appui\Menu();
$shortcuts = $menu->shortcuts();
if ( !empty($model->data['prepath']) ){
  $prepath = $model->data['prepath'];
  return array_map(function($a) use($prepath){
    if ( Str::pos($a['url'], $prepath) === 0 ){
      $a['url'] = Str::sub($a['url'], Str::len($prepath)+1);
    }
    return $a;
  }, $shortcuts);
}
return $shortcuts;
