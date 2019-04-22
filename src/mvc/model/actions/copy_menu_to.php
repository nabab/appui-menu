<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 12/10/17
 * Time: 14.57
 */

$res['success'] = false;



if ( !empty($model->data['public_menu_to']) &&
  (!$model->inc->user->is_admin() &&
  !$model->inc->user->is_dev())
){
  return $res;
}

if ( !empty($model->data) &&
  !empty($model->data['id']) &&
  !empty($model->data['id_menu_to'])
){

  $cfg = [
    'text' => empty($model->data['text']) ? _('New section') : $model->data['text'],
    'icon' => empty($model->data['icon']) ? "nf nf-fa-cogs" : $model->data['icon']
  ];


  if ( !empty($cfg) && empty($model->data['menu_node']) ){

    if ( $model->inc->menu->copy(
      $model->data['id'],
      $model->data['id_menu_to'],
      $cfg )
    ){
      $res['success'] = true;
    }
  }
  else{


    if ( $model->inc->menu->copy_to(
      $model->data['id'],
      $model->data['id_menu_to'],
      $cfg)
    ){
      $res['success'] = true;
    }
  }
}

return $res;
