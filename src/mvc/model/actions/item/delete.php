<?php
if (
  !empty($model->data['id']) &&
  \bbn\str::is_uid($model->data['id']) &&
  ($menu = $model->inc->pref->get($model->inc->menu->get_id_menu($model->data['id'])))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->is_admin() &&
    !$model->inc->user->is_dev()
  ){
    return ['success' => false];
  }
  if ( $model->inc->menu->remove($model->data['id']) ){
    return ['success' => true];
  }
}
return ['success' => false];
