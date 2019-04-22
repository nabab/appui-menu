<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 17/10/17
 * Time: 17.18
 */


$res['success'] = false;

if ( !empty($model->data['public']) &&
  (!$model->inc->user->is_admin() &&
  !$model->inc->user->is_dev())
){
  return $res;
}

if ( $num = $model->inc->menu->remove($model->data['id']) ){
  $res = [
    'success' => true,    
    'listMenu' => $model->inc->menu->get_menus()
  ];
}
return $res;
