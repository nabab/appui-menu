<?php

/** @var bbn\Mvc\Model $model */
$res = ['success' => false];
if ( isset($model->data['id']) ){
  $res['success'] = $model->inc->menu->removeShortcut($model->data['id'], $model->inc->pref);
}
return $res;