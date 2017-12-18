<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$res = ['success' => false];
if ( isset($model->data['id']) ){
  if ( $res['id'] = $model->inc->menu->add_shortcut($model->data['id'], $model->inc->pref) ){
    $res['success'] = true;
  }
}
return $res;