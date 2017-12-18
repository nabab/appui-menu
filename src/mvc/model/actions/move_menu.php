<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 19/10/17
 * Time: 11.39
 */

$res['success'] = false;

if ( !empty($model->data['id_parent']) && !empty($model->data['id']) ){
  if ( $model->inc->options->move( $model->data['id'], $model->data['id_parent']) ){
    $res['success'] = true;
  };
}

return $res;