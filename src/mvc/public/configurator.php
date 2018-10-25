<?php

if ( !isset($ctrl->post['id']) ){
  $permission = $ctrl->inc->options->from_code('page', 'permissions', 'appui' );
  $id_menus = $ctrl->inc->options->from_code('menus', 'menus', 'appui');
  $id_default = $ctrl->inc->options->from_code('default', 'menus', 'menus', 'appui');

  $ctrl->add_data([
    'cat' => $ctrl->inc->options->from_code(false),
    'is_dev' => $ctrl->inc->user->is_dev(),
    'id_permission' => $permission,
    //'permRoot' => $ctrl->inc->perm->get_option_root(),
    'id_parent' => $id_menus,
    'id_default' => $id_default,
    'listMenu' => $ctrl->inc->options->full_options($id_menus)
  ]);
  $ctrl->combo(_("Menu Configurator"), $ctrl->data);
}
else {
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
