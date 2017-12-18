<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 08/11/17
 * Time: 11.03
 */


$res['success'] = false;

if ( isset($model->data['id']) && isset($model->data['destination']) ){
  //$ele = $model->inc->options->from_code($model->data['source']);
  $ele1 = $model->inc->options->full_options( $model->data['source'] );

  die(var_dump($ele1));

  /*
  if ( $model->inc->options->add([
      'id_parent' => $model->data['destination'],
      '' => $model->data['source']
    ])
  ){
    $res['success'] = true;
  };
*/
}
return $res;