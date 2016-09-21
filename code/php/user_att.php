<?php

define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'sys_loginBean.php';
require_once  LOGIC_ROOT.'user_attestationBean.php';

$ib = new sys_loginBean();
$ub = new user_attestationBean();

 $user = $_SESSION['userinfo'];
 if($user != null){
 	$userid = $user->id;
 	$type=$user->type;
 }else{
 	redirect("login.php?dir=user");
 	return;
 }

 $obj_user = $ib->detail($db,$userid);
 $obj = $ub->detail($db,$userid);
include "tpl/user_att_web.php";


?>
