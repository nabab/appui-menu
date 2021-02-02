<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/
$res = ['success' => false];
if ( isset($model->data['id']) ){
  $res['success'] = $model->inc->menu->removeShortcut($model->data['id'], $model->inc->pref);
}
return $res;