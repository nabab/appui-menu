<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 27/10/17
 * Time: 13.32
 */


$res['success'] = false;

if ( !empty($model->data['public']) &&
  (!$model->inc->user->is_admin() &&
  !$model->inc->user->is_dev())
){
  return $res;
}

if ( !empty($model->data['id']) &&
     !empty($model->data['newTitle']) &&
     !empty($model->inc->menu->set_text($model->data['id'],  $model->data['newTitle']))
){
  $res = [
    'success' => true,
    'listMenu' => $model->inc->menu->get_menus()
  ];
}
return $res;
