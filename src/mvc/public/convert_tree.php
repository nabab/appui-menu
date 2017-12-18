<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 07/11/17
 * Time: 17.54
 */

//$ctrl->obj = $ctrl->get_object_model($ctrl->post);
$menus = $ctrl->inc->options->full_tree('ce4a81f1bff511e7b7d5000c29703ca2');
die(\bbn\x::dump($menus));
$user = \bbn\user::get_user();
$id_alias = $ctrl->db->get_one("SELECT id_alias FROM bbn_options WHERE $ctrl->post['id']");
die(var_dump($user));
/*
$insert = $ctrl->db->insert('bbn_users_options', [
  'id_option' => $ctrl->post['id'],
  'id_user' => $user,
  'id_alias' => $id_alias
  ]);
*/