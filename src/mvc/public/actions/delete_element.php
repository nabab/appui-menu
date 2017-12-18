<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 17/10/17
 * Time: 17.19
 */

if (
  !empty($ctrl->post['id']) &&
  !empty($ctrl->post['id_parent'])
){
   $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}