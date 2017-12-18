<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 16/10/17
 * Time: 11.58
 */
if ( !empty($ctrl->post['id_parent']) &&
  !empty($ctrl->post['titleMenu'])
){
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
