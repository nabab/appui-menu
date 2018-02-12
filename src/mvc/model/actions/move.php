<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 19/10/17
 * Time: 11.39
 */

$res['success'] = false;

if (
  isset($model->data['id_parent'], $model->data['id']) &&
  ($opt = $model->inc->options->option($model->data['id_parent'])) &&
  ($id_menu = $model->inc->menu->get_id_menu($model->data['id_parent'])) &&
  ($res['success'] = $opt['id_alias'] ?
    $model->inc->options->order($model->data['id'], $model->inc->options->order($model->data['id_parent'])) :
    $model->inc->options->move( $model->data['id'], $model->data['id_parent']))
){
  $model->inc->menu->delete_cache($id_menu);
}
return $res;