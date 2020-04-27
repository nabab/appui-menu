<?php
if (
  !empty($model->data['id']) &&
  !empty($model->data['text']) &&
  ($menu = $model->inc->pref->get($model->data['id']))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->is_admin() &&
    !$model->inc->user->is_dev()
  ){
    return ['success' => false];
  }
  if ( $model->inc->menu->set_text($model->data['id'],  $model->data['text']) ){
    return ['success' => true];
  }
}
