<?php
if (
  !empty($model->data['id']) &&
  \bbn\Str::isUid($model->data['id']) &&
  ($menu = $model->inc->pref->get($model->inc->menu->getIdMenu($model->data['id'])))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->isAdmin() &&
    !$model->inc->user->isDev()
  ){
    return ['success' => false];
  }
  if ( $model->inc->menu->remove($model->data['id']) ){
    return ['success' => true];
  }
}
return ['success' => false];
