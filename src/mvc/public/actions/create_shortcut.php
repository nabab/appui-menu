<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 08/11/17
 * Time: 11.03
 */

if ( isset($ctrl->post) &&
  isset($ctrl->post['source']) &&
  isset($ctrl->post['destination'])
){
  $ctrl->obj = $ctrl->getObjectModel($ctrl->post);
}
