<?php

/** @var $this \bbn\Mvc\Model*/
$res = ['success' => false];
if ( isset($model->data['id']) ){
  if ( $res['id'] = $model->inc->menu->addShortcut($model->data['id'], $model->inc->pref) ){
    $res['success'] = true;
  }
}
return $res;