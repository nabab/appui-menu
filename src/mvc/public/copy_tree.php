<?php

if ( !empty($ctrl->post['id']) ){  
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
