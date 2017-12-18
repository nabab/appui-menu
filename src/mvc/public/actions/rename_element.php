<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 19/10/17
 * Time: 11.40
 */

if ( !empty($ctrl->post['id']) ){
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
