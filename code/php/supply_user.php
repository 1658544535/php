<?php

define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'sys_loginBean.php';
require_once  LOGIC_ROOT.'user_infoBean.php';
require_once  LOGIC_ROOT.'user_orderBean.php';
require_once  LOGIC_ROOT.'user_order_detailBean.php';

$ib = new sys_loginBean();
$cb = new user_infoBean();
$ob = new user_orderBean();
$c2b = new user_order_detailBean();


$user = $_SESSION['userinfo'];
if($openid != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=user");
	return;
}

$obj_user = $ib->detail($db,$userid);
$couponList = $cb->get_results_userid($db,$userid);
$onway_orders = $ob->get_results_onway($db,$userid);	//已发货订单
$un_comment_orders = $ob->get_results_not_comment($db,$userid);	//未评价的订单
$product_count = 0;
foreach($un_comment_orders as $obj){
	$cart2s = $c2b->get_results_order($db,$obj->order_id);
	$product_count += count($cart2s);
}

include "tpl/supply_user_web.php";
?>
