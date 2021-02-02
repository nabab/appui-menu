<?php
if (
  !empty($model->data['id_menu']) &&
  \bbn\Str::isUid($model->data['id_menu']) &&
  (\bbn\Str::isUid($model->data['id_parent']) || is_null($model->data['id_parent'])) &&
  isset($model->data['deep']) &&
  ($menu = $model->inc->pref->get($model->data['id_menu']))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->isAdmin() &&
    !$model->inc->user->isDev()
  ){
    return ['success' => false];
  }
  return [
    'success' => true,
    'fixed' => $model->inc->menu->fixOrder($model->data['id_menu'], $model->data['id_parent'], $model->data['deep'])
  ];
}
return ['success' => false];