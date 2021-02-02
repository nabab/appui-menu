<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 12/10/17
 * Time: 14.57
 */
if (
  !empty($model->data['id']) &&
  !empty($model->data['title']) &&
  ($id = $model->inc->menu->clone($model->data['id'], $model->data['title']))
){
  return [
    'success' => true,
    'menus' => $model->inc->menu->getMenus('name', 'id'),
    'id' => $id
  ];
}
return ['success' => false];
