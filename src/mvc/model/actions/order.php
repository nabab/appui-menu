<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 19/10/17
 * Time: 11.39
 */
$res = ['success' => false ];
if ( !empty($model->inc->options) && !empty($model->data['id'])
){
  if ( !empty($model->inc->options->order($model->data['id'], $model->data['num'])) ){
    $res['success'] = true;
  }
  if ( !empty($model->data['id_parent']) ){
    $res['menu'] =  $model->inc->options->full_options($model->data['id_parent']);
    $model->inc->menu->delete_cache($model->data['id_parent']);
  }
}

return $res;
