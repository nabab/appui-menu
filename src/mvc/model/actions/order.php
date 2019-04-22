<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 19/10/17
 * Time: 11.39
 */

$res = ['success' => false ];
if ( !empty($model->inc->menu) &&
  !empty($model->data['id_menu']) &&
  !empty($model->data['id']) &&
  !empty($model->data['num'])
){
   $bits= $model->inc->menu->order($model->data['id'], $model->data['num']);
  if ( !empty($bits) ){
    $res['success'] = true;
  }
  $res['menu'] = $model->inc->pref->get_bits($model->data['id_menu'], $model->data['id_parent'] ?? null);
  if ( \is_array($res['menu']) && !empty($res['menu']) ){
    foreach ($res['menu'] as $key => $value) {
      $res['menu'][$key]['num_children'] = count($model->inc->pref->get_bits($model->data['id_menu'], $value['id']));
      $res['menu'][$key]['path'] = $value['id_option'] === null ? [] : $model->inc->options->sequence($value['id_option'], $model->inc->perm->get_option_id('page'));
      if ( !empty($res['menu'][$key]['path']) ){
        array_shift($res['menu'][$key]['path']);
      }
    }
    $model->inc->menu->delete_cache($model->data['id_menu']);
  }
}
return $res;
