<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 27/10/17
 * Time: 13.32
 */


$res['success'] = false;

if ( !empty($model->data['id']) &&
     !empty($model->data['newTitle'])
   ){
    if (isset($model->data['id_parent']) ){
      //if ( $model->inc->options->set_text($model->data['id'],  $model->data['newTitle'] ) ){
      if ( $model->inc->menu->set_text($model->data['id'],  $model->data['newTitle'] ) ){
        $res = [
          'success' => true,
          'listMenu' => $model->inc->options->full_options($model->data['id_parent']),
        ];
      }
    }
    else{
     //if ( $model->inc->options->set_text($model->data['id'],  $model->data['newTitle']) ){
     if ( $model->inc->menu->set_text($model->data['id'],  $model->data['newTitle']) ){
       $res = [
         'success' => true,
         'listMenu' => false,
       ];
     }
   }
}
return $res;