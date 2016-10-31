<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $model \bbn\mvc\model*/
$menu = new \bbn\appui\menu($model->inc->options, $model->inc->pref);
$shortcuts = $menu->shortcuts($model->inc->pref);

if ( !empty($model->data['prepath']) ){
  $prepath = $model->data['prepath'];
  return array_map(function($a) use($prepath){
    if ( strpos($a['url'], $prepath) === 0 ){
      $a['url'] = substr($a['url'], strlen($prepath)+1);
    }
    return $a;
  }, $shortcuts);
}
return $shortcuts;
