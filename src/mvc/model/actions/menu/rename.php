<?php
if (
  !empty($model->data['id']) &&
  !empty($model->data['text']) &&
  ($menu = $model->inc->pref->get($model->data['id']))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->isAdmin() &&
    !$model->inc->user->isDev()
  ){
    return ['success' => false];
  }
  if ( $model->inc->menu->setText($model->data['id'],  $model->data['text']) ){
    return ['success' => true];
  }
}
