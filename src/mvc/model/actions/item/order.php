<?php

/**
 * @var bbn\Mvc\Model $model
 **/
if ($model->hasData(['id_menu', 'id', 'num'], true)
    && ($menu = $model->inc->pref->get($model->data['id_menu']))
) {
  if (!empty($menu['public'])
      && !$model->inc->user->isAdmin()
      && !$model->inc->user->isDev()
  ) {
    return ['success' => false];
  }
  return ['success' => $model->inc->menu->order($model->data['id'], $model->data['num'])];
}
return ['success' => false];
