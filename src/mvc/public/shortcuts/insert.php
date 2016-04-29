<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $this \bbn\mvc\controller */
if ( isset($this->post['id']) ){
  $menu = new \bbn\appui\menu($this->inc->options);
  $this->obj->success = $menu->add_shortcut($this->post['id'], $this->inc->pref);
}