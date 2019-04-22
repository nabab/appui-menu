<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 10/11/17
 * Time: 15.07
 */


if ( !empty($model->data['menu']['value']) &&
  isset($model->data['menu']['public']) &&
  !empty($model->data['text'])
){

  if ( !empty($model->data['menu']['public']) &&
    (!$model->inc->user->is_admin() &&
    !$model->inc->user->is_dev())
  ){
    return [
      'success' => false
    ];
  }

  $cfg = [
    'text' => $model->data['text'],
    'icon' => $model->data['icon'],
    'id_parent' => \bbn\str::is_uid($model->data['id_parent']) ? $model->data['id_parent'] : NULL,
    'id_option' => \bbn\str::is_uid($model->data['id_option']) ? $model->data['id_option'] : NULL,
    'num' =>  $model->data['num'] ?? NULL
  ];

  if( !empty($model->data['id_option']) &&
   \bbn\str::is_uid($model->data['id_option']) &&
   !empty($model->data['argument'])
  ){
    $cfg['argument'] = $model->data['argument'];
  }

  // case add
  if ( !empty($model->data['create']) ){
    if ( !empty($model->inc->menu->add($model->data['menu']['value'], $cfg)) ){
      return [
        'success' => true,
        'create' => true
      ];
    }
    else{
      return [
        'success' => false,
        'create' => false
      ];
    }
  }
  else{
    if ( !empty($model->inc->menu->set($model->data['id'], $cfg)) ){
      return [
        'success' => true,
        'edit' => true
      ];
    }
    else{
      return [
        'success' => false,
        'edit' => false
      ];
    }
  }
}

return [
  'success' => false
];
