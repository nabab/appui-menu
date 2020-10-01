<?php

/**
 * @var bbn\mvc\model $model
 **/
if ($model->has_data(['id_menu', 'id', 'num'], true)
    && ($menu = $model->inc->pref->get($model->data['id_menu']))
) {
  if (!empty($menu['public'])
      && !$model->inc->user->is_admin()
      && !$model->inc->user->is_dev()
  ) {
    return ['success' => false];
  }
  return ['success' => $model->inc->menu->order($model->data['id'], $model->data['num'])];
}
return ['success' => false];
