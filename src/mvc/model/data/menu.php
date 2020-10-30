<?php
/** @var $model \bbn\mvc\model*/
$res = [
  'success' => false,
  'data' => []
];
if (isset($model->data['data'])) {
  $model->data = $model->data['data'];
}

if (!empty($model->data['id_menu'])) {
  $menus       = new bbn\appui\menus();
  $res['data'] = $model->inc->pref->get_bits(
    $model->data['id_menu'],
    $model->data['id'] ?? null
  );

  if (\is_array($res['data']) && !empty($res['data'])) {
    foreach ($res['data'] as $k => &$d) {
      $d['numChildren'] = count($model->inc->pref->get_bits($model->data['id_menu'], $d['id']));
      if (!is_null($d['id_option'])
          && ($sequence = $model->inc->options->sequence($d['id_option'], $model->inc->perm->get_option_id('page')))
      ) {
        $d['path'][] = $sequence;
      }
      else{
        $d['path'] = [];
      }

      // $d['path'] = $d['id_option'] ? [] : 
      //  $model->inc->options->sequence($d['id_option'], $model->inc->perm->get_option_id('page'));
      if (!empty($d['path'][0])) {
        array_shift($d['path'][0]);
      }

      if (!$d['numChildren'] && isset($d['id_option']) && ($tmp = $menus->to_path($d['id_option']))) {
        $d['link'] = $tmp;
      }
    }

    unset($d);
    $res['success'] = true;
  }

  return $res;
}
