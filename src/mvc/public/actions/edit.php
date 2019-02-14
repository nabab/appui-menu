<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 10/11/17
 * Time: 15.07
 */

if ( !empty($ctrl->post) ){ 
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
