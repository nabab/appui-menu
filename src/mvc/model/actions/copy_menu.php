<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 12/10/17
 * Time: 14.57
 */


$res['success'] = false;
$running = false;

if ( !empty($model->data) &&
     !empty($model->data['id_copy']) &&
     !empty($model->data['id_parent']) &&
     !empty($model->data['newTitleMenu']) &&
     !empty($model->data['nameCopyMenu'])
){
  if ( $model->data['nameCopyMenu'] !== $model->data['newTitleMenu'] ){
    $opt = $model->inc->options->full_tree($model->data['id_copy']);
    if ( isset($opt['code']) && !empty($opt['code']) ){
      $opt['code'] = null;
      $opt['num'] = null;
      $opt['text'] = $model->data['newTitleMenu'];
      unset($opt['id']);
      if ( $id = $model->inc->menu->add($model->data['id_parent'], $opt) ){
        $running = true;
       }
    }
    else {
      $id = $model->inc->options->duplicate(
        $model->data['id_copy'],
        $model->data['id_parent'],
        true,
        false
      );
      if ( $id ){
        if ( $model->inc->menu->set($id,
          [
            'id_parent' => $model->data['id_parent'],
            'text' => $model->data['newTitleMenu']
          ])
        ){
          $running = true;
        };
      }
    }
    if ( $running === true ){
      $res = [
        'success' => true,
        'listMenu' => $model->inc->options->full_options($model->data['id_parent'])
      ];
    }
  }
  else{
    $res = [
      'success' => false,
      'errorMessage' => true
    ];
  }
}

return $res;
