<?php
if (
  !empty($model->data['id_menu']) &&
  \bbn\str::is_uid($model->data['id_menu']) &&
  (\bbn\str::is_uid($model->data['id_parent']) || is_null($model->data['id_parent'])) &&
  isset($model->data['deep']) &&
  ($menu = $model->inc->pref->get($model->data['id_menu']))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->is_admin() &&
    !$model->inc->user->is_dev()
  ){
    return ['success' => false];
  }
  return [
    'success' => true,
    'fixed' => $model->inc->menu->fix_order($model->data['id_menu'], $model->data['id_parent'], $model->data['deep'])
  ];
}
return ['success' => false];