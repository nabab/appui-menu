<?php
if (
  !empty($model->data['id_parent']) &&
  !empty($model->data['id']) &&
  \bbn\Str::isUid($model->data['id']) &&
  \bbn\Str::isUid($model->data['id_parent']) &&
  ($bit = $model->inc->pref->getBit($model->data['id_parent'])) &&
  is_null($bit['id_option']) &&
  ($menu = $model->inc->pref->get($model->inc->menu->getIdMenu($model->data['id']))) &&
  ($menu2 = $model->inc->pref->get($model->inc->menu->getIdMenu($model->data['id_parent'])))
){
  if (
    (!empty($menu['public']) || !empty($menu2['public'])) &&
    !$model->inc->user->isAdmin() &&
    !$model->inc->user->isDev()
  ){
    return ['success' => false];
  }
  return ['success' => $model->inc->menu->move($model->data['id'], $model->data['id_parent'])];
}
return ['success' => false];
