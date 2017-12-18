<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 16/10/17
 * Time: 11.58
 */


$res['success'] = false;

if ( isset($model->data['id_parent']) && isset($model->data['titleMenu']) ){
  if ( $id = $model->inc->options->add([
    'id_parent' => $model->data['id_parent'],
    'text' => $model->data['titleMenu']
  ])
  ){

    $res = [
      'success' => true,
      'listMenu' => $model->inc->options->full_options($model->data['id_parent']),
      'idNew' => $id
    ];

  };
}
return $res;

