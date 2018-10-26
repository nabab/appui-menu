<?php
if ( !empty($ctrl->post) ){
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
