<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $this \bbn\mvc\model*/
$menu = new \bbn\appui\menu($this->inc->options, $this->inc->pref);
$shortcuts = $menu->shortcuts($this->inc->pref);
$prepath = $this->get_prepath();
if ( !empty($prepath) ){
  return array_map(function($a) use($prepath){
    if ( strpos($a['link'], $prepath) === 0 ){
      $a['link'] = substr($a['link'], strlen($prepath)+1);
    }
    return $a;
  }, $shortcuts);
}
return $shortcuts;
