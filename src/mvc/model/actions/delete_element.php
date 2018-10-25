<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 17/10/17
 * Time: 17.18
 */


$res['success'] = false;
$default = $model->inc->options->from_code('menus', 'menus', 'appui');
if (
  !empty($model->data['id']) && ($model->data['id'] !== $default) &&
  ($num = $model->inc->menu->remove($model->data['id']))
){
  $res = [
    'success' => true,
    'num' => $num,
    'listMenu' => $model->inc->options->full_options($model->data['id_parent'])
  ];
}
return $res;
