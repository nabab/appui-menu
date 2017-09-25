<?php
if ( isset($ctrl->post['id']) ){
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
else{
  $ctrl->combo(_("test tree"));
}