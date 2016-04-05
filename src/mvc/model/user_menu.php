<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $this \bbn\mvc\model*/

$menu = new \bbn\appui\menu($this->inc->options);
if ( isset($this->inc->pref) ){
  return $menu->custom_tree('default', $this->inc->pref);
}
else{
  return $menu->tree('default');
}