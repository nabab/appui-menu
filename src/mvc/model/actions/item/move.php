<?php
if (
  !empty($model->data['id_parent']) &&
  !empty($model->data['id']) &&
  \bbn\str::is_uid($model->data['id']) &&
  \bbn\str::is_uid($model->data['id_parent']) &&
  ($bit = $model->inc->pref->get_bit($model->data['id_parent'])) &&
  is_null($bit['id_option']) &&
  ($menu = $model->inc->pref->get($model->inc->menu->get_id_menu($model->data['id']))) &&
  ($menu2 = $model->inc->pref->get($model->inc->menu->get_id_menu($model->data['id_parent'])))
){
  if (
    (!empty($menu['public']) || !empty($menu2['public'])) &&
    !$model->inc->user->is_admin() &&
    !$model->inc->user->is_dev()
  ){
    return ['success' => false];
  }
  return ['success' => $model->inc->menu->move($model->data['id'], $model->data['id_parent'])];
}
return ['success' => false];
