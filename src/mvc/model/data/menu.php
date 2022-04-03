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
    $sources = $model->inc->perm->getSources();
    $routes = $model->getRoutes();
    foreach ($res['data'] as $i => $d) {
      $res['data'][$i]['rootAccess'] = '';
      if (!empty($d['link'])) {
        $bits = explode('/', $d['link']);
        if (array_key_exists($bits[0], $routes)) {
          $res['data'][$i]['rootAccess'] = \bbn\X::getField(
            $sources,
            ['code' => $routes[$bits[0]]['name']],
            'rootAccess'
          );
        }
      }
    }
    $res['success'] = true;
  }

}

return $res;
