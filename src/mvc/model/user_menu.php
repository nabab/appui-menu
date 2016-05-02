<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $this \bbn\mvc\model*/

$menu = new \bbn\appui\menu($this->inc->options);
if ( isset($this->inc->pref) ){
  return $menu->custom_tree('default', $this->inc->pref, isset($this->data['prepath']) ? $this->data['prepath'] : false);
}
else{
  return $menu->tree('default', isset($this->data['prepath']) ? $this->data['prepath'] : false);
}