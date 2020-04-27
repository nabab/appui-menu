<?php
if (
  !empty($model->data['id']) &&
  \bbn\str::is_uid($model->data['id']) &&
  ($menu = $model->inc->pref->get($model->data['id']))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->is_admin() &&
    !$model->inc->user->is_dev()
  ){
    return ['success' => false];
  }
  if ( $model->inc->menu->remove($model->data['id']) ){
    return [
      'success' => true,
      'menus' => $model->inc->menu->get_menus('name', 'id')
    ];
  }
}
return ['success' => false];
