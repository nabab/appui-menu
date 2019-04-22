<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 19/10/17
 * Time: 11.39
 */

$res['success'] = false;

if ( (!empty($model->data['id_parent']) && !empty($model->data['id'])) &&
  ($bit = $model->inc->pref->get_bit($model->data['id_parent'])) &&
  ($id_menu = $model->inc->menu->get_id_menu($model->data['id_parent']))
){
  if ( $bit['id_option'] === null ){
    if ( $res['success'] = $model->inc->menu->move($model->data['id'], $model->data['id_parent']) ){
      $model->inc->menu->delete_cache($id_menu);
    }
  }
}

return $res;
