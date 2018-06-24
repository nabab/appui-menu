<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 10/11/17
 * Time: 15.07
 */

$res['success'] = false;

if ( !empty($model->data['text']) &&  !empty($model->data['icon']) && !empty($model->data['id_parent']) ){


  if(  !empty($model->data['create']) && ($model->data['id_alias'] !== 1) ){

    if( $model->data['id_alias'] !== null ){
      $cfg=[
        'id_parent' => $model->data['id_parent'],
        'text' => $model->data['text'],
        'icon' => $model->data['icon'],
        'id_alias' => $model->data['id_alias'],
        //'path' => $model->data['path'],
        //'numChildren' => 0,
        'items' => []
      ];
      if ( !empty($model->data['argument']) ){
        array_push($cfg, 'value', $model->data['argument'] );
      }
    }
    if( $model->data['id_alias'] === null ){

      $cfg=[
        'id_parent' => $model->data['id_parent'],
        'text' => $model->data['text'],
        'icon' => $model->data['icon'],
        'id_alias' => $model->data['id_alias'],
        //'numChildren' => 0,
        'items' => []
      ];
    }

    if ( $id = $model->inc->menu->add($model->data['id_parent'], $cfg) ){
      $cfg['id'] = $id;
      $cfg['path'] = $model->data['path'];
      $res = [
        'success' => true,
        'create' => true,
        'params' => $cfg
      ];
     // die(var_dump($res));
    }
    else{
      $res = [
        'success' => false,
        'create' => false,
      ];
    }
  }
  else if( !empty($model->data['id']) ){
    $cfg= [
      'id_parent' => $model->data['id_parent'],
      'text' => $model->data['text'],
      'icon' => $model->data['icon'],
      'id_alias' => $model->data['id_alias']
    ];
    if ( !empty($model->data['argument']) ){
      array_push($cfg, 'value', $model->data['argument'] );
    }
    // if ( $id_set = $model->inc->options->set($model->data['id'], $cfg) ){
    if ( $id_set = $model->inc->menu->set($model->data['id'], $cfg) ){
      $cfg['id'] = $id_set;

      $res = [
        'success' => true,
        'id' => $id_set,
        'params' => $cfg
      ];

    };
  }
}
//die(var_dump("entaro", $res));
return $res;
