<?php
/*
 * Describe what it does!
 *
 **/

use bbn\X;
/** @var $this \bbn\Mvc\Model*/
$res = ['success' => false];
if (!isset($model->data['id']) && $model->hasData(['url', 'text', 'icon'], true)) {
  if ($res['id'] = $model->inc->menu->addShortcutByUrl($model->data['url'], $model->data['text'], $model->data['icon'])) {
    $res['success'] = true;
  }
}
elseif (isset($model->data['id'])){
  if ($res['id'] = $model->inc->menu->addShortcut($model->data['id'])) {
    $res['success'] = true;
  }
}
return $res;