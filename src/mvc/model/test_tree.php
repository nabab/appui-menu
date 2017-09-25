<?php
/** @var $model \bbn\mvc\model*/
return [
  'success' => true,
  'data' => $model->inc->options->full_options($model->data['id'])
];