<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */
if ( isset($ctrl->post['id']) ){
  $menu = new \bbn\appui\menu($ctrl->inc->options);
  $ctrl->obj->success = $menu->remove_shortcut($ctrl->post['id'], $ctrl->inc->pref);
}