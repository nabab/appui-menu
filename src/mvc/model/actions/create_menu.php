88<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 16/10/17
 * Time: 11.58
 */


$res['success'] = false;

if ( !empty($model->data['titleMenu']) &&
 ($id = $model->inc->menu->add(['text' => $model->data['titleMenu']]))
){
  $res = [
    'success' => true,
    'listMenu' =>  $model->inc->menu->get_menus(),
    'idNew' => $id
  ];

}
return $res;
