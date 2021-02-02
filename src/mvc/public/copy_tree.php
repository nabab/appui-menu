<?php

if ( !empty($ctrl->post['id']) ){  
  $ctrl->obj = $ctrl->getObjectModel($ctrl->post);
}
