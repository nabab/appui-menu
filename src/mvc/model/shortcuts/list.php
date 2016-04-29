<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $this \bbn\mvc\model*/
$menu = new \bbn\appui\menu($this->inc->options, $this->inc->pref);
return $menu->shortcuts($this->inc->pref);

