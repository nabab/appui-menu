<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

return [
  'rootPermission' => $model->inc->options->fromCode('access', 'permissions', 'appui'),
  'defaultMenu' => $model->inc->menu->getDefault(),
  'sources' => $model->inc->perm->getSources(false),
  'menus' => $model->inc->menu->getMenus('name', 'id')
];