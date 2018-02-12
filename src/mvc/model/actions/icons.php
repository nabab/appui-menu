<?php

$data_icons = $model->get_model('iconology');
$res = [];
$tot = [];
$type = "";
foreach($data_icons as $k => $val){
  if( $k !== "total" ){
    switch ( $k ){
      case "faicons": $type = "fa fa-";
      break;
      case "material": $type = "zmdi zmdi-";
      break;
      case "mficons": $type = "icon-";
      break;
    }
    $res[$k] =[];
    if( $k === "mficons" ){
      foreach($val as  $id => $v){
        foreach($v['icons'] as $icon){
          array_push($tot, $type.$icon);
          array_push($res[$k], $type.$icon);
        }
      }
    }
    else{
      foreach($val as  $id => $v){
        array_push($tot, $type.$v);
        array_push($res[$k], $type.$v);
      }
    }
  }
}

return [
  'icons' => $res,
  'list' => $tot,
  'total' => $data_icons['total']
];
