<?php
/** @var $model \bbn\mvc\model*/
$res = [
  'success' => false,
  'data' => []
];
if ( isset($model->data['data']) ){
  $model->data = $model->data['data'];
}
if ( !empty($model->data['id_menu']) ){
  $res['data'] = $model->inc->pref->get_bits($model->data['id_menu'], $model->data['id'] ?: null);
  if ( is_array($res['data']) && !empty($res['data']) ){
    foreach ($res['data'] as $key => $value) {
      $res['data'][$key]['numChildren'] = count($model->inc->pref->get_bits($model->data['id_menu'], $value['id']));
      if (
        !is_null($value['id_option']) &&
        ($sequence = $model->inc->options->sequence($value['id_option'], $model->inc->perm->get_option_id('page')))
      ){
        $res['data'][$key]['path'][] = $sequence;
      }
      else{
        $res['data'][$key]['path'] = [];
      }
      //$res['data'][$key]['path'] = $value['id_option'] === null ? [] : $model->inc->options->sequence($value['id_option'], $model->inc->perm->get_option_id('page')) ];
      if ( !empty($res['data'][$key]['path'][0]) ){
        array_shift($res['data'][$key]['path'][0]);
      }
    }
    $res['success'] = true;
  }
  return $res;
}
