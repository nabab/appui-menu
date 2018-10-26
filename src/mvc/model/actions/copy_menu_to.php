<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 12/10/17
 * Time: 14.57
 */


$res['success'] = false;

if ( !empty($model->data) &&
     !empty($model->data['id']) &&
     !empty($model->data['id_parent'])
){
  if(  $model->inc->options->duplicate(
      $model->data['id'],
      $model->data['id_parent'],
      true,
      false
    ) ){
      $res['success'] = true;
  }
}

return $res;
