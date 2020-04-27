<?php
if (
  !empty($model->data['to']) &&
  ($to = $model->inc->pref->get($model->data['to'])) &&
  !empty($model->data['id_user_option']) &&
  ($menu = $model->inc->pref->get($model->data['id_user_option'])) &&
  !empty($model->data['text'])
){
  if (
    !empty($to['public']) &&
    !$model->inc->user->is_admin() &&
    !$model->inc->user->is_dev()
  ){
    return ['success' => false];
  }
  if ( $model->inc->menu->copy($model->data['id_user_option'], $model->data['to'], [
    'text' => $model->data['text'],
    'icon' => $model->data['icon'] ?: 'nf nf-fa-cogs'
  ]) ){
    return ['success' => true];
  }
}
return ['success' => false];