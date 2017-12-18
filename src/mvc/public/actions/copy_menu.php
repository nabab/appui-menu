<?php
if ( isset($ctrl->post) &&
     isset($ctrl->post['id_copy']) &&
     isset($ctrl->post['id_parent']) &&
     isset($ctrl->post['newTitleMenu'])
){
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
