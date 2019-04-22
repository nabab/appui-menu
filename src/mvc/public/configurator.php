<?php

if ( !isset($ctrl->post['id_menu']) ){
  $permission = $ctrl->inc->options->from_code('page', 'permissions', 'appui' );
  $ctrl->obj->bcolor = '#54aedb';
  $ctrl->obj->fcolor = '#FFF';
  $ctrl->obj->icon = 'nf nf-fa-bars';
  $menus = $ctrl->inc->menu->get_menus();
  $id_menu_default = $ctrl->inc->menu->get_default();


  $ctrl->add_data([
    'cat' => $ctrl->inc->options->from_code(false),
    'is_dev' => $ctrl->inc->user->is_dev(),
    'id_permission' => $permission,
    //'permRoot' => $ctrl->inc->perm->get_option_root(),
    'id_menu_default' => $id_menu_default,
    'listMenu' => $menus
  ]);
  $ctrl->combo(_("Menu Configurator"), $ctrl->data);
}
else {
  //die(\bbn\x::dump($ctrl->post));
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
