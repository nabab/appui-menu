<?php
/** @var $model \bbn\mvc\model*/
$res = [
  'success' => false,
  'data' => []
];

/** @todo Put all this in menu class */
if (isset($model->data['data'])) {
  $model->data = $model->data['data'];
}

if (!empty($model->data['id_menu'])) {
  $menu        = new bbn\appui\menu();
  $res['data'] = $menu->get($model->data['id_menu']);
  if (\is_array($res['data']) && !empty($res['data'])) {
    $res['success'] = true;
  }

}

return $res;
