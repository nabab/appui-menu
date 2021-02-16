<?php
/** @var $model \bbn\Mvc\Model*/
$res = [
  'success' => false,
  'data' => []
];

/** @todo Put all this in menu class */
if (isset($model->data['data'])) {
  $model->data = $model->data['data'];
}

if (!empty($model->data['id_menu'])) {
  $menu        = new bbn\Appui\Menu();
  $res['data'] = $menu->get($model->data['id_menu'], $model->hasData('id', true) ? $model->data['id'] : null);
  if (\is_array($res['data']) && !empty($res['data'])) {
    $res['success'] = true;
  }

}

return $res;
