<?php
/** @var $model \bbn\mvc\model*/
if ( isset($model->data['id']) ){
  $res = [
    'success' => false,
    'data' => $model->inc->options->full_options($model->data['id']),
  ];
  if ( \is_array($res['data']) ){
    foreach ( $res['data'] as $k => $d ){
      $res['data'][$k]['path'] = empty($d['id_alias']) ? [] : $model->inc->options->sequence($d['id_alias'], $model->inc->perm->get_option_id('page'));
      if ( !empty($res['data'][$k]['path']) ){
        array_shift($res['data'][$k]['path']);
      }
    }
    $res['success'] = true;
  }
  return $res;
}