<?php
if (
  !empty($model->data['id_menu']) &&
  \bbn\str::is_uid($model->data['id_menu']) &&
  !empty($model->data['id']) &&
  \bbn\str::is_uid($model->data['id']) &&
  !empty($model->data['num']) &&
  ($menu = $model->inc->pref->get($model->data['id_menu']))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->is_admin() &&
    !$model->inc->user->is_dev()
  ){
    return ['success' => false];
  }
  return ['success' => $model->inc->menu->order($model->data['id'], $model->data['num'])];
}
return ['success' => false];
