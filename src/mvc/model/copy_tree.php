<?php
/** @var bbn\Mvc\Model $model */
$res = [
  'success' => false,
  'data' => []
];

if ( !empty($model->data['id']) ){
  $tree = $model->inc->options->fullOptions($model->data['id']);
  if ( \is_array($tree) ){
    foreach ( $tree as $k => $d ){
      if( $d['id_alias'] === null ){
        $d['num'] = 0;
        $d['num_children'] = 0;
        $items = $model->inc->options->fullOptions($d['id']);
        if ( \is_array($items) ){
          foreach ( $items as $item ){
            if( $item['id_alias'] === null ){
              $d['num']++;
              $d['num_children']++;
            }
          }
        }
        $res['data'][] = $d;
      }
    }
  }
  if ( count($res['data']) > 0 ){
    $res['success'] = true;
  }
  return $res;
}
return $res;
