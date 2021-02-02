<?php
if (
  !empty($model->data['id']) &&
  ($bit = $model->inc->pref->getBit($model->data['id'])) &&
  !empty($model->data['to']) &&
  ($to = $model->inc->pref->get($model->data['to'])) &&
  !empty($model->data['id_user_option']) &&
  ($menu = $model->inc->pref->get($model->data['id_user_option'])) &&
  !empty($model->data['text'])
){
  if (
    !empty($to['public']) &&
    !$model->inc->user->isAdmin() &&
    !$model->inc->user->isDev()
  ){
    return ['success' => false];
  }
  if ( $model->inc->menu->copyTo($model->data['id'], $model->data['to'], [
    'text' => $model->data['text'],
    'icon' => $model->data['icon'] ?: 'nf nf-fa-cogs'
  ]) ){
    return ['success' => true];
  }
}
return ['success' => false];

