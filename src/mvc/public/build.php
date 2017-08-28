<?php
if ( !isset($ctrl->arguments[0]) ){
  $ctrl->add_data([
    'cat' => 288224056,
    'is_admin' => $ctrl->inc->user->is_admin(),
    'lng' => [
      'problem_while_moving' => _("Sorry, a problem occured while moving this item, and although the tree says otherwise the item has not been moved."),
      'please_refresh' => _("Please refresh the tab in order to see the awful truth..."),
      'confirm_move' => _("Are you sure you want to move this option? Although the configuration will remain the same, the access path will be changed.")
    ]
  ]);
  $ctrl->combo(_("build"), $ctrl->data);
}
else{
  /** @var \bbn\appui\options $o */
  $o =& $ctrl->inc->options;
  $res = $o->full_options_cfg($ctrl->arguments[0]);
  $res2 = $res;
  //die(\bbn\x::hdump($res2));
  $ctrl->obj->data = $res2 ?: [];
}
