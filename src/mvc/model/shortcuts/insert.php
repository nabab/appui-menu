<?php

use bbn\X;
/** @var bbn\Mvc\Model $model */
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