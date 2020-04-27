88<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 16/10/17
 * Time: 11.58
 */
if (
  !empty($model->data['title']) &&
 ($id = $model->inc->menu->add(['text' => $model->data['title']]))
){
  return [
    'success' => true,
    'menus' =>  $model->inc->menu->get_menus('name', 'id'),
    'id' => $id
  ];

}
return ['success' => false];
