<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$res = ['success' => false];
if ( isset($model->data['id']) ){
  $res['success'] = $model->inc->menu->remove_shortcut($model->data['id'], $model->inc->pref);
}
return $res;