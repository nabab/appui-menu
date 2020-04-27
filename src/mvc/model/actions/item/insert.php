<?php
if (
  !empty($model->data['id_user_option']) &&
  (\bbn\str::is_uid($model->data['id_parent']) || is_null($model->data['id_parent'])) &&
  (\bbn\str::is_uid($model->data['id_option']) || is_null($model->data['id_option'])) &&
  !empty($model->data['text']) &&
  ($menu = $model->inc->pref->get($model->data['id_user_option']))
){
  if (
    !empty($menu['public']) &&
    !$model->inc->user->is_admin() &&
    !$model->inc->user->is_dev()
  ){
    return ['success' => false];
  }
  $cfg = [
    'text' => $model->data['text'],
    'icon' => $model->data['icon'],
    'id_parent' => $model->data['id_parent'],
    'id_option' => $model->data['id_option'],
    'num' =>  $model->data['num'] ?? $model->inc->pref->get_max_bit_num($model->data['id_user_option'], $model->data['id_parent'], true)
  ];
  if(
   \bbn\str::is_uid($model->data['id_option']) &&
   !empty($model->data['argument'])
  ){
    $cfg['argument'] = $model->data['argument'];
  }
  if ( $id = $model->inc->menu->add($model->data['id_user_option'], $cfg) ){
    return [
      'success' => true,
      'item' => $model->inc->pref->get_bit($id, true)
    ];
  }
}
return ['success' => false];
