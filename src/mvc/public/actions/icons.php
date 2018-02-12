<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 17/10/17
 * Time: 15.11
 */
if ( isset($ctrl->post['index']) && $ctrl->post['index'] === true  ){
  $ctrl->obj = $ctrl->get_cached_model(30000);
}
