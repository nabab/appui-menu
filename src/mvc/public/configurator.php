<?php
$ctrl
  ->combo(_("Menu Configurator"), [
    'rootPermission' => $ctrl->inc->options->from_code('page', 'permission', 'appui'),
    'defaultMenu' => $ctrl->inc->menu->get_default(),
    'menus' => $ctrl->inc->menu->get_menus('name', 'id')
  ])
  ->set_color('#54aedb', '#FFF')
  ->set_icon('nf nf-fa-bars');