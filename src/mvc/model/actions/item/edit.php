<?php
if (
  !empty($model->data['id']) &&
  !empty($model->data['id_user_option']) &&
  (\bbn\Str::isUid($model->data['id_parent']) || is_null($model->data['id_parent'])) &&
  (\bbn\Str::isUid($model->data['id_option']) || is_null($model->data['id_option'])) &&
  !empty($model->data['text']) &&
  ($menu = $model->inc->pref->get($model->data['id_user_option']))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->isAdmin() &&
    !$model->inc->user->isDev()
  ){
    return ['success' => false];
  }
  $cfg = [
    'text' => $model->data['text'],
    'icon' => $model->data['icon'],
    'id_parent' => $model->data['id_parent'],
    'id_option' => $model->data['id_option'],
    'num' =>  $model->data['num'] ?? $model->inc->pref->getMaxBitNum($model->data['id_user_option'], $model->data['id_parent'], true)
  ];
  if(
   \bbn\Str::isUid($model->data['id_option']) &&
   !empty($model->data['argument'])
  ){
    $cfg['argument'] = $model->data['argument'];
  }
  if ( $model->inc->menu->set($model->data['id'], $cfg) ){
    return [
      'success' => true,
      'item' => $model->inc->pref->getBit($model->data['id'], true)
    ];
  }
}
return ['success' => false];
